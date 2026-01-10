<?php

namespace App\Http\Requests\User;

use App\Enum\UseCase\UserGoal\TypeGoalUpdate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

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
            'goal' => ['required', new Enum(TypeGoalUpdate::class)]
        ];
    }

    public function messages()
    {
        return [
            'goal.required' => 'O tipo do ponto é obrigatório!',
            'goal.enum' => 'O tipo de ponto é inválido!'
        ];
    }
}
