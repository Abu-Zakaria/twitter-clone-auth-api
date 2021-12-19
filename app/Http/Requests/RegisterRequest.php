<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;

class RegisterRequest extends FormRequest
{
    protected function authorize(): bool
    {
        return !auth()->check();
    }

    protected function rules(): array
    {
        return [
            'email' => 'required|email',
            'username' => 'required|alpha_num',
            'password' => 'required|min:6|max:125',
        ];
    }

    public function register()
    {
    }
}
