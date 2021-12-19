<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;

class LoginRequest extends FormRequest
{
    protected function authorize(): bool
    {
        return !auth()->check();
    }

    protected function rules(): array
    {
        return [
            'username_or_email' => 'required',
            'password' => 'required|min:6|max:125',
        ];
    }

    public function login()
    {
        dd($this->all());
    }
}
