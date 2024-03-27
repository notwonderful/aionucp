<?php

namespace Database\Factories\Game;

use App\Models\Game\AccountData;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AccountDataFactory extends Factory
{
    protected $model = AccountData::class;

    public function definition(): array
    {
        return [
            'name' => $this->fakeName(),
            'email' => $this->fakeEmail(),
            'password' => base64_encode(sha1('password', true)),
            'toll' => $this->faker->numberBetween(0, 10000),
        ];
    }

    private function fakeName(): string
    {
        $name = $this->faker->firstName() . $this->faker->lastName();
        return Str::lower(str_replace(' ', '', $name));
    }

    private function fakeEmail(): string
    {
        return Str::lower($this->faker->unique()->safeEmail());
    }
}
