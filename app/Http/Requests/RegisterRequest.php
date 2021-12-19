<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;
use App\Models\User;

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
        return User::create([
            'username' => $this->username,
            'email' => $this->email,
            'password' => password_hash($this->password, PASSWORD_DEFAULT),
        ]);
    }
}
