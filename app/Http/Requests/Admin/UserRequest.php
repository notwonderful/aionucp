<?php

namespace App\Http\Requests\Admin;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $user = $this->route('user');

        return [
            'email' => ['string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'balance' => ['nullable', 'integer', 'max:10000'],
            'role' => [Rule::enum(UserRole::class)],
        ];
    }
}
