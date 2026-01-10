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
            'user_id' => ['sometimes', 'exists:App\\Models\\User,id'], 
            'goal' => ['required', new Enum(TypeGoalUpdate::class)],
            'value_goal' =>  ['sometimes', 'numeric']
        ];
    }

    public function messages()
    {
        return [
            'user_id.exists' => 'O identificador do usuário não existe!',
            'goal.required' => 'O tipo do ponto é obrigatório!',
            'goal.enum' => 'O tipo de ponto é inválido!',
            'value_goal.numeric' => 'O valor da meta precisar estar em um formato válido!'

        ];
    }
}
