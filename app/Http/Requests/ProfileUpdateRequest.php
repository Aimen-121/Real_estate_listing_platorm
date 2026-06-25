<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'Full_Name' => ['required', 'string', 'max:100'],
            'Email' => [
                'required',
                'string',
                'email',
                'max:100',
                Rule::unique('user', 'Email')->ignore($this->user()->User_ID, 'User_ID'),
            ],
            'Phone_Number' => ['nullable', 'string', 'max:20'],
        ];
    }
}
