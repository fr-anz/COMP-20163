# backend

Laravel 13 backend with Composer dependencies, PHPUnit starter tests, and local SQLite. The root route returns a readiness JSON response, `/up` is Laravel's health route, and `routes/api.php` is ready for future application endpoints. No commerce or authentication features are implemented.

## Requirements

- PHP 8.4 or newer and Composer 2. The framework supports PHP 8.3+, but this project's dependency lock is resolved for PHP 8.4 to match Docker/CI. PHP 8.5 also works.
- Laravel's standard PHP extensions, plus `pdo_sqlite` and `sqlite3` for the local database. Enable ZIP or provide an unzip utility for Composer archive extraction.

On Windows, use `php --ini` to locate the active configuration and `php -m` to list enabled extensions. Required bundled DLLs can be enabled in that configuration; do not use Composer's ignore-platform flags to bypass missing extensions.

If Composer stalls while extracting archives on Windows, retry with serial processing in that PowerShell session:

```powershell
$env:COMPOSER_MAX_PARALLEL_PROCESSES = '1'
composer install --no-interaction --prefer-dist --no-progress
```

## First setup

From this folder:

```sh
composer run setup
```

This installs locked Composer dependencies, creates `.env` if absent, generates a local application key, creates the SQLite file if absent, and runs Laravel's default migrations. Run this for initial setup; use `composer install` for later dependency synchronization so you do not regenerate an existing application key.

`.env`, `database/database.sqlite`, `vendor/`, and runtime files are ignored by Git. Keep `.env.example` and `composer.lock` committed. The SQLite database is a local development default, not a settled production database choice.

## Run and verify

```sh
composer run dev
```

Open `http://localhost:8000` or `http://localhost:8000/up`. Stop the server with Ctrl+C. Vue runs separately from `frontend/`; no backend npm install or Vite build is needed.

```sh
composer validate --strict
composer check-platform-reqs
composer test
```

The tests are framework starter checks, not coverage for future commerce behavior. PHPUnit uses in-memory SQLite and array-backed session/cache settings, leaving the local development database untouched.
