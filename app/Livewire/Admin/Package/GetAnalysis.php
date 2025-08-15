<?php

namespace App\Livewire\Admin\Package;

use App\Enums\Gender;
use App\Enums\Relationship;
use App\Helpers\OpenAIHelper;
use App\Models\Analysis;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class GetAnalysis extends Component
{
    public $packages = [];
    protected $messages = [];
    public $questions = [];
    public $package_id = '';
    public $name = 'مسعود';
    public $dob = '1371/03/10';
    public $gender = '1';
    public $relationship = '2';

    public $answers = [];
    public $response = '';

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|min:3',
            'dob' => ['required', 'regex:/^1[3-4]\d{2}\/(0[1-9]|1[0-2])\/(0[1-9]|[12]\d|3[01])$/'],
            'gender' => 'required|integer|in:' . implode(',', Gender::values()),
            'relationship' => 'required|integer|in:' . implode(',', Relationship::values()),
        ];
        foreach ($this->questions as $question) {
            $rules['answers.' . $question->id] = 'required';
            $this->messages['answers.' . $question->id . '.required'] = 'پاسخ به این سوال اجباری است.';
        }
        return $rules;
    }

    public function mount()
    {
        $this->packages = Package::all();
    }

    public function render()
    {
        return view('livewire.admin.package.get-analysis', [
            'genders' => Gender::cases(),
            'relationships' => Relationship::cases(),
        ]);
    }

    public function updatedPackageId($value)
    {
        $this->questions = Package::find($this->package_id)->questions;
        $this->emptyForm();
    }

    protected function emptyForm()
    {
//        $this->name = '';
//        $this->dob = '';
//        $this->gender = '';
//        $this->relationship = '';
        $this->answers = [];
        $this->response = '';
    }

    public function new()
    {
        $this->package_id = '';
        $this->emptyForm();
    }

    public function submit()
    {
        $this->validate();
        $info = [
            'name' => $this->name,
            'dob' => $this->dob,
            'gender' => Gender::labelFor($this->gender),
            'relationship' => Relationship::labelFor($this->relationship),
        ];

        $r = OpenAIHelper::getAnalysis($this->package_id, $info, $this->answers);
        if ($r['status']) {
            $analysis = Analysis::create([
                'package_id' => $this->package_id,
                'name' => $this->name,
                'dob' => $this->dob,
                'gender' => $this->gender,
                'relationship' => $this->relationship,
                'causer_id' => Auth::id(),
                'prompt' => $r['data']['prompt'],
                'analysis' => $r['data']['analysis'],
            ]);
            foreach ($this->answers as $key => $value) {
                $analysis->answers()->create([
                    'package_question_id' => $key,
                    'content' => $value,
                ]);
            }
            $this->response = $r['data']['analysis'];
        }
    }
}
