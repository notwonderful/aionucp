<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Enums\EmulatorType;
use App\Enums\EncryptionType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ServerRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:30'],
            'status' => ['boolean'],
            'sort' => ['integer', 'min:0'],
            'is_default' => ['boolean'],
            'emulator_type' => ['required', Rule::enum(EmulatorType::class)],
            'encryption_type' => ['required', Rule::enum(EncryptionType::class)],
            'db_host' => ['required', 'string', 'max:255'],
            'db_port' => ['required', 'integer', 'min:1', 'max:65535'],
            'db_database' => ['required', 'string', 'max:255'],
            'db_username' => ['required', 'string', 'max:255'],
            'db_password' => ['required', 'string', 'max:255'],
            'db_driver' => ['string', 'in:mysql,pgsql,sqlsrv'],
        ];
    }
}
