<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserGoalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['sometimes', 'exists:App\\Models\\User,id'],
            'pulled' =>  ['sometimes', 'numeric'],
            'called' =>  ['sometimes', 'numeric'],
            'whatsApp' =>  ['sometimes', 'numeric'],
            'indicate' =>  ['sometimes', 'numeric'],
            'xremote' =>  ['sometimes', 'numeric'],
            'chat' =>  ['sometimes', 'numeric'],
        ];
    }

    public function messages()
    {
        return [
            'user_id.exists' => 'O identificador do usuário não existe!',
            'pulled.numeric' => 'O valor de puxei precisa ser um número!',
            'called.numeric' => 'O valor de liguei precisa ser um número!',
            'whatsApp.numeric' => 'O valor de whatsApp precisa ser um número!',
            'indicate.numeric' => 'O valor de indique e ganhe precisa ser um número!',
            'xremote.numeric' => 'O valor de xremote precisa ser um número!',
            'chat.numeric' => 'O valor de chat precisa ser um número!',
        ];
    }
}
