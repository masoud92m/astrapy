<?php

namespace App\Livewire\Site\Package;

use App\Helpers\OpenAIHelper;
use App\Models\Analysis;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GetAnalysis extends Component
{
    protected $messages = [];
    public $questions = [];
    public $package_id = '';
    public $answers = [];
    public $response = '';

    protected function rules()
    {
        $rules = [];
        foreach ($this->questions as $question) {
            $key = 'answers.' . $question->id;
            $fieldRules = [];
            if ($question->is_required) {
                $fieldRules[] = 'required';
                $this->messages[$key . '.required'] = 'پاسخ به این سوال اجباری است.';
            }

            if ($question->type === 'date') {
                $fieldRules[] = 'regex:/^1[3-4]\d{2}\/(0[1-9]|1[0-2])\/(0[1-9]|[12]\d|3[01])$/';
                $this->messages[$key . '.regex'] = 'فرمت تاریخ معتبر نیست. مثل ۱۳۷۵/۰۵/۲۲ وارد کن.';
            }

            $rules[$key] = $fieldRules;
        }

        return $rules;
    }


    public function mount($package_id)
    {
        $this->package_id = $package_id;
        $this->questions = Package::with('questions.options')->find($this->package_id)->questions;
    }

    public function render()
    {
        return view('livewire.site.package.get-analysis');
    }

    protected function emptyForm()
    {
        $this->answers = [];
        $this->response = '';
    }

    public function submit()
    {
        $this->validate();

        $r = OpenAIHelper::getAnalysis($this->package_id, $this->answers);
        if ($r['status']) {
            $analysis = Analysis::create([
                'package_id' => $this->package_id,
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
