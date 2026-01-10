<?php

namespace App\Http\Requests\Auth;

use App\Messages\Auth\AuthMessages;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'unique:App\\Models\\User,email'],
            'team' => ['required', 'string', Rule::in([
                'Cinza',
                'Azul',
                'Verde',
                'Vermelho',
                'Roxo',
                'Marrom',
                'Laranja',
                'Amarelo'
            ])],
            'password' => ['required', 'string', 'min:8', 'max:120'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => AuthMessages::EMAIL_REQUIRED->value,
            'email.email' => AuthMessages::EMAIL_FORMAT->value,
            'email.unique' => AuthMessages::EMAIL_UNIQUE->value,

            'name.required' => AuthMessages::NAME_REQUIRED->value,
            'name.string' => AuthMessages::NAME_FORMAT->value,
            'name.max' => AuthMessages::NAME_MAX->value,

            'team.required' => AuthMessages::TEAM_REQUIRED->value,
            'team.string' => AuthMessages::TEAM_FORMAT->value,
            'team.in' => AuthMessages::TEAM_IN->value,

            'password.required' => AuthMessages::PASSWORD_REQUIRED->value,
            'password.string' => AuthMessages::PASSWORD_FORMAT->value,
            'password.max' => AuthMessages::PASSWORD_MAX->value,
            'password.min' => AuthMessages::PASSWORD_MIN->value,
        ];
    }
}
