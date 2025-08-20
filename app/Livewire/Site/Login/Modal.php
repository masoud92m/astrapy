<?php

namespace App\Livewire\Site\Login;

use App\Enums\Gender;
use App\Enums\Relationship;
use Livewire\Component;

class Modal extends Component
{
    public $show = true;

    public $name = '';
    public $dob = '';
    public $gender = '';
    public $relationship = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|min:3',
            'dob' => ['required', 'regex:/^14\d{2}\/(0[1-9]|1[0-2])\/(0[1-9]|[12]\d|3[01])$/'],
            'gender' => 'required|integer|in:' . implode(',', Gender::values()),
            'relationship' => 'required|integer|in:' . implode(',', Relationship::values()),
        ];
    }

    protected $messages = [
        'name.required' => 'نام و نام خانوادگی الزامی است.',
        'name.string' => 'نام و نام خانوادگی باید متن باشد.',
        'name.min' => 'نام و نام خانوادگی باید حداقل ۳ کاراکتر باشد.',

        'dob.required' => 'تاریخ تولد الزامی است.',
        'dob.regex' => 'تاریخ تولد باید به فرمت ۱۴۰۰/۰۱/۰۱ باشد.',

        'gender.required' => 'انتخاب جنسیت الزامی است.',
        'gender.in' => 'جنسیت انتخاب شده معتبر نیست.',

        'relationship.required' => 'انتخاب وضعیت رابطه الزامی است.',
        'relationship.in' => 'وضعیت رابطه انتخاب شده معتبر نیست.',
    ];

    public function mount()
    {
        $this->show = !session()->has('skip-modal');
    }

    public function skip()
    {
        session()->push('skip-modal', true);
        $this->dispatch('close-modal');
    }

    public function submit()
    {
        $this->validate();

        session(['onboarding_data' => [
            'name' => $this->name,
            'dob' => $this->dob,
            'gender' => $this->gender,
            'relationship' => $this->relationship,
        ]]);

        session(['onboarded' => true]);
        $this->show = false;
        $this->dispatch('login-modal-finished');
    }

    public function render()
    {
        return view('livewire.site.login.modal', [
            'genders' => Gender::cases(),
            'relationships' => Relationship::cases(),
        ]);
    }
}
