<?php

use App\Models\Game\AccountData;
use Illuminate\Support\Str;

test('import game accounts command', function () {

    AccountData::query()->insert([
        ['id' => 1, 'name' => 'testuser1', 'email' => 'testuser1@example.com', 'password' => base64_encode(sha1(Str::password(), true))],
        ['id' => 2, 'name' => 'testuser2', 'email' => 'testuser2@example.com', 'password' => base64_encode(sha1(Str::password(), true))],
    ]);

    $this->artisan('import:game-accounts')
        ->assertExitCode(0);

    $this->assertDatabaseHas('users', [
        'email' => 'testuser1@example.com',
    ]);

    $this->assertDatabaseHas('users', [
        'email' => 'testuser2@example.com',
    ]);
});
