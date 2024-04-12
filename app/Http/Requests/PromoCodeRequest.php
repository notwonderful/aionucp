<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class PromoCodeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'code' => ['required','string', 'min:5', 'max:1000'],
            'toll' => ['required', 'int', 'min:10', 'max:10000', function ($attribute, $value, $fail) {
                /** @var User $user */
                $user = auth()->user();
                if ($user->balance < $value) {
                    $fail(__('Not enough balance!'));
                }
            }],
           'user_id' => ['required', 'exists:App\Models\User,id']
        ];
    }
}
