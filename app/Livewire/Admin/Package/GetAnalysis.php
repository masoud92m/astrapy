<?php

namespace App\Livewire\Admin\Package;

use App\Enums\Gender;
use App\Enums\Relationship;
use App\Helpers\OpenAIHelper;
use App\Models\Package;
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
    public $response = '' ;

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

    public function updated()
    {
        $this->questions = Package::find($this->package_id)->questions;
    }

    public function new()
    {
        $this->package_id = '';
        $this->name = '';
        $this->dob = '';
        $this->gender = '';
        $this->relationship = '';
        $this->answers = [];
    }

    public function submit()
    {
        $this->validate();

        $package = Package::find($this->package_id);

        $info = [
            'نام' => $this->name,
            'تاریخ تولد شمسی' => $this->dob,
            'جنسیت' => Gender::labelFor($this->gender),
            'وضعیت رابطه' => Relationship::labelFor($this->relationship),
        ];

        $prompt = [];
        $prompt[] = $package->prompt1;
        $prompt[] = 'اطلاعات اولیه موردنیاز:';

        foreach ($info as $key => $value) {
            $prompt[] = $key . ': ' . $value;
        }

        $questions = $this->questions->pluck('content', 'id')->toArray();
        foreach ($this->answers as $key => $value) {
            $prompt[] = $questions[$key] . ': ' . $value;
        }

        $prompt[] = $package->prompt2;
        $content = implode("\n", $prompt);
//        dd($content);
        $messages = [
            ['role' => 'system', 'content' => 'طبق توضیحاتی که در اماده میاد، میخوام یه متن برای برای یه پکیج آسترولوژی بنویسی، دقت کن این روانشناسی نیست به هیچ وجه، لطفا فقط متن رو بنویس و هیچ توضیح اضافه در اول یا در آخر نده'],
            ['role' => 'user', 'content' => $content],
        ];
        ini_set('max_execution_time', 60);
        $this->response = OpenAIHelper::chat($messages, max_tokens: 500);
    }
}
