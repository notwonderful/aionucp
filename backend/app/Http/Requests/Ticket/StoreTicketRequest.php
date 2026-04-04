<?php

declare(strict_types=1);

namespace App\Http\Requests\Ticket;

use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Stevebauman\Purify\Facades\Purify;

final class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();
        assert($user instanceof User);

        $openTickets = Ticket::where('user_id', $user->id)
            ->whereNot('status', 'closed')
            ->count();

        return $openTickets < 10;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'subject' => strip_tags($this->string('subject')->trim()->value()),
            'body' => Purify::clean($this->string('body')->value()),
        ]);
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
