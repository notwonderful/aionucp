<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\Game\MembershipDuration;
use App\Enums\Game\MembershipType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class MembershipRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'membership_type' => ['required', Rule::enum(MembershipType::class)],
            'duration' => ['required', Rule::enum(MembershipDuration::class)],
        ];
    }
}
