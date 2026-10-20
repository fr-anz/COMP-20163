# CI and Docker

## Current scope

Vue 3/Vite/TypeScript and Laravel 13 are initialized. CI checks documentation, builds the development toolchain image, builds/type-checks Vue, and runs Laravel's test suite, including demo seed and public health checks. Vue includes the initial barebones storefront layouts; functional commerce features remain separate work, tracked in [the published GitHub backlog](github-issue-drafts.md).

## GitHub Actions

[The CI workflow](../.github/workflows/ci.yml) runs for pull requests, pushes, and manual dispatch. A local `git pull` does not trigger GitHub Actions. The workflow becomes active when committed and pushed; the manual dispatch option appears after it reaches the default branch.

It has two checks:

- **Markdown lint**: runs `markdownlint-cli2` version `0.23.3` against the repository's Markdown. The root configuration permits long prose lines and unaligned Markdown table columns; other default rules remain enabled.
- **Docker build and application checks**: builds the root Dockerfile and verifies its tools, non-root user, writable workspace, and baseline PHP extensions. Separate disposable containers run `npm ci`/`npm run build` in `frontend/`, and Composer validation/install plus Laravel's tests in `backend/`.

The backend test container creates its own `.env` and application key. PHPUnit uses in-memory SQLite; development databases and keys are excluded from the image. Dependency lockfiles are installed without updating their versions.

The workflow uses read-only repository permissions, does not retain checkout credentials, and publishes no images or deployments. Action versions are pinned to commit SHAs. A newer run cancels an older run for the same pull request or Git ref.

Run the Markdown check locally with Node.js 24:

```sh
npx --yes markdownlint-cli2@0.23.3
```

To make CI mandatory before merging, configure a repository ruleset or branch protection rule after these checks have run. This setup does not modify repository protection settings.

## Development image

[The Dockerfile](../Dockerfile) provides Node.js 24 with npm/npx, PHP 8.4 CLI, Composer 2, Git, and unzip. It uses official Node, PHP, and Composer images and runs as the `app` user (UID 1000), with `/workspace` as the working directory.

The image opens a shell rather than starting application servers or installing application dependencies during the image build. There is no external database service or production deployment. The default shell exits in noninteractive use, so use `-it` for an interactive session or supply a command.

From the repository root, with Docker running in Linux-container mode:

```sh
docker build --pull -t ecommerce-dev .
docker run --rm ecommerce-dev node --version
docker run --rm ecommerce-dev php --version
docker run --rm ecommerce-dev composer --version
docker run --rm -it ecommerce-dev
```

The image includes a snapshot of the scaffold. To work on the live checkout instead, bind-mount it into `/workspace`.

PowerShell:

```powershell
docker run --rm -it --mount "type=bind,source=$($PWD.Path),target=/workspace" ecommerce-dev
```

POSIX shell:

```sh
docker run --rm -it --user "$(id -u):$(id -g)" --env COMPOSER_HOME=/tmp/composer --env npm_config_cache=/tmp/npm --mount "type=bind,source=$(pwd),target=/workspace" ecommerce-dev
```

The POSIX command uses the host UID/GID so files remain editable outside the container. Bind mounts use host permissions rather than the ownership baked into the image. Run `npm ci` in `/workspace/frontend` and `composer run setup` in `/workspace/backend` for first setup. Host dependencies are not automatically copied into the image.

To serve the apps from a bind-mounted container, also publish ports with `-p 5173:5173 -p 8000:8000` and bind both servers to `0.0.0.0`: `npm run dev -- --host 0.0.0.0` and `php artisan serve --host=0.0.0.0 --port=8000`, each from its app directory in separate container shells. Keep container-installed Node dependencies separate from Windows-installed `node_modules`; native build packages differ by platform.

[The Docker ignore file](../.dockerignore) excludes Git data, dependency/build output, logs, and local environment/authentication files; `.env.example` remains eligible for copying. A bind mount bypasses build-context exclusions and exposes the mounted checkout to the development container.

## Extending application checks

- Keep frontend/backend manifests and lockfiles synchronized and committed. The current workflow installs both lockfiles and runs their starter checks.
- Add frontend interaction tests and backend feature tests as actual behavior is implemented. The current frontend build includes TypeScript checking; Laravel tests include the demo catalog seed's contents/repeatability and public readiness/health responses.
- Keep tests independent of real payments and real customer data. Add application-specific services, extensions, ports, and runtime images only when their requirements are established.

Do not treat the starter checks as commerce test coverage. SQLite is a local development/test default; production database and hosting decisions remain open. Docker build/container execution cannot be verified on a host without Docker, even when the equivalent local build/test commands pass.
