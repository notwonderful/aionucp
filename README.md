## AionUCP (User Control Panel)

## Features

- Login / Registration / Logout / Password Recovery / Password Change and Email Change
- Balance replenishment via [Palych.io](https://palych.io) and [Payop.com](https://payop.com)
- Currency conversion
- Membership Purchase
- Character Unstuck
- Referral Program
- Promo Codes
- Mail Items
- Bulk Email
- Shop
- Rating (Abyss and Legions)
- Test coverage (currently not all tests are successful, as I literally threw together the user panel in a day and am just continuing today).
- Account import. Useful if you already have a game server and need to import existing game accounts into the WEB database. Please note that your users will need to use the password recovery function.

## Requirements ⚙️

AionUCP is a regular Laravel 11 application, so it can be installed on any server that meets the [Laravel server requirements](https://laravel.com/docs/11.x/deployment#server-requirements). 

## Installation

- Step 1. `cp .env.example .env`
- Step 2. Launch CLI and run the command `composer install` and `php artisan key:generate`
- Step 3. Open `.env` and specify database credentials, etc
- Step 4. Run the `php artisan migrate` and `php artisan storage:link`
- Step 5. Go to [Google Recaptcha Admin](https://www.google.com/recaptcha/admin/create) and create recaptcha v3 for your domain. Then specify the secret and client key inside the `.env` file.
- Step 6. After finishing the setup, run the command `php artisan config:cache` for faster configuration loading

## 🔒 Security Policy

This project has a [security policy](.github/SECURITY.md).
