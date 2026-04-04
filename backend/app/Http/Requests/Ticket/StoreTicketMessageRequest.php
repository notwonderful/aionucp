<?php

declare(strict_types=1);

namespace App\Http\Requests\Ticket;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Stevebauman\Purify\Facades\Purify;

final class StoreTicketMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        $ticket = $this->route('ticket');
        assert($ticket instanceof Ticket);

        return $this->user()?->id === $ticket->user_id
            && $ticket->status !== TicketStatus::CLOSED;
    }

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
            'body' => ['required', 'string', 'min:1', 'max:10000'],
        ];
    }
}
