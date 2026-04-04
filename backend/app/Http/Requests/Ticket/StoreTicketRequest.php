<?php

declare(strict_types=1);

namespace App\Http\Requests\Ticket;

use App\Models\TicketCategory;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Stevebauman\Purify\Facades\Purify;

final class StoreTicketRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if ($this->has('body')) {
            $this->merge(['body' => Purify::clean($this->string('body')->value())]);
        }
    }

    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'subject' => ['required', 'string', 'min:3', 'max:255'],
            'category_id' => ['required', 'exists:'.TicketCategory::class.',id'],
            'body' => ['required', 'string', 'min:10', 'max:10000'],
        ];
    }
}
