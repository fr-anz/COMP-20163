# backend

Laravel 13 backend with Composer dependencies, local SQLite, and a repeatable one-garment demo catalog seed. The root route returns a readiness JSON response, `/up` is Laravel's health route, and `routes/api.php` is ready for future application endpoints. Commerce and authentication routes are specified in [the API contracts](../docs/api.md) and remain dependent implementation work.

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

This installs locked Composer dependencies, creates `.env` if absent, generates a local application key, creates the SQLite file if absent, and runs migrations. Run this for initial setup; use `composer install` for later dependency synchronization so you do not regenerate an existing application key.

`.env`, `database/database.sqlite`, `vendor/`, and runtime files are ignored by Git. Keep `.env.example` and `composer.lock` committed. The SQLite database is a local development default, not a settled production database choice.

## Migrate and seed the demo catalog

After initial setup, or after pulling schema changes:

```sh
php artisan migrate
php artisan db:seed
```

On a fresh database, this creates exactly one `cotton-overshirt` listing: size M, good/gently worn condition, 56/72/59 cm chest/length/sleeve measurements, PHP 85000 minor units (₱850.00), and available status. Its photo and GLB model references are explicit placeholders with null URLs. Actual permitted media and a rotatable model are supplied in issues #3/#9; no broken asset URLs are seeded.

Repeat these commands safely: the unique demo slug identifies the seed, and an existing listing is left unchanged, including its price and sold status. The seed does not erase other listings or provision users/administrator credentials. On a database with existing application data, "exactly one" refers to the demo fixture added by the seed, not deletion of other records. Keep the demo slug stable if you want subsequent seeds to recognize it. Use a separate disposable database for a pristine demo reset.

SQLite is the development default; PHPUnit uses an isolated in-memory SQLite database. Production database selection is still open. Administrator authentication will use Sanctum session cookies, with local secret provisioning and no public registration, as specified in [the access contract](../docs/api.md#sessions-and-access). Issue #2 implements this approach; no login endpoint exists yet.

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

The tests cover framework starter behavior, public readiness/health, and the demo seed's contents and repeatability. They do not cover unimplemented commerce routes. PHPUnit uses in-memory SQLite and array-backed session/cache settings, leaving the local development database untouched.
