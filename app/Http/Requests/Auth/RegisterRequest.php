<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'Name' => 'nullable|string|max:255',
            'Phone' => 'required|string|max:255|unique:users,Phone|required_without:Email',
            'Email' => 'required|string|email|max:255|unique:users,Email|required_without:Phone',
            'Password' => 'required|string|min:8|confirmed|regex:/A-Z/',
        ];
    }
}