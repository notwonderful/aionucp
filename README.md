## AionUCP (User Control Panel)

## Features

- Login / Registration / Logout/ Password Recovery / Password Change and Email Change
- Balance replenishment (only Palych.io)
- Currency conversion.
- Membership Purchase
- Character Unstuck
- Test coverage (currently not all tests are successful, as I literally threw together the user panel in a day and am just continuing today).
- Account import. Very useful if you already have a game server and need to import existing game accounts into the WEB database. Please note that your users will need to use the password recovery function.

## Requirements ⚙️

AionUCP is a regular Laravel 11 application, so it can be installed on any server that meets the [Laravel server requirements](https://laravel.com/docs/11.x/deployment#server-requirements). 

## Installation

- Step 1. `cp .env.example .env`
- Step 2. Launch CLI and run the command `composer install` and `php artisan key:generate`
- Step 3. Open `.env` and specify database credentials, etc
- Step 4. Run the `php artisan migrate`, `npm install` and `npm run build`
- Step 5. After finishing the setup, run the command `php artisan config:cache` for faster configuration loading

## Security Vulnerabilities

If you discover a security vulnerability within AionUCP, please send an message to my Telegram via [@notwonderful](https://t.me/notwonderful). All security vulnerabilities will be promptly addressed.
