# E-Commerce

A Vue 3/Vite/TypeScript frontend and Laravel 13 backend for an e-commerce school project, with GitHub Actions CI and a Docker development toolchain.

Both frameworks are initialized with locked dependencies and basic readiness pages. Storefront layouts, commerce behavior, and administrator features remain planned work. Existing folder READMEs describe their intended responsibilities.

## Local development

Use Node.js 24.12+, PHP 8.4+, and Composer 2. PHP needs Laravel's standard extensions and SQLite support.

In one terminal:

```sh
cd frontend
npm ci
npm run dev
```

In another terminal, for first setup:

```sh
cd backend
composer run setup
composer run dev
```

Vue normally runs at `http://localhost:5173`; Laravel runs at `http://localhost:8000`, with health at `/up`. See the [frontend guide](frontend/README.md) and [backend guide](backend/README.md) for build/test commands and environment setup.

## CI and development tools

GitHub Actions checks Markdown, builds/smoke-tests the Docker development image, type-checks/builds Vue, and validates/tests Laravel on pull requests and pushes. The image provides Node.js 24, PHP 8.4, and Composer 2; it opens a shell rather than automatically starting either application.

See [CI and Docker setup](docs/ci-and-docker.md) for local commands and workflow behavior.

## Team workflow

Create feature branches from `staging` and open pull requests back to `staging`. Promote reviewed, tested versions through a `staging` → `main` pull request. `main` remains the default branch; `staging` is the shared integration branch for MVP v1 and later iterations.

See [branching and pull request conventions](docs/branching.md) for branch names, Conventional Commits, review expectations, and merge practices.

## Folder structure

```text
E-Commerce/
|-- frontend/
|   |-- public/
|   |-- src/
|   |   |-- assets/
|   |   |-- components/
|   |   |   |-- common/
|   |   |   |-- catalog/
|   |   |   `-- cart/
|   |   |-- composables/
|   |   |-- layouts/
|   |   |-- pages/
|   |   |-- router/
|   |   |-- services/
|   |   |-- stores/
|   |   `-- utils/
|   `-- tests/
|-- backend/
|   |-- app/
|   |   |-- Http/
|   |   |   |-- Controllers/
|   |   |   |-- Middleware/
|   |   |   |-- Requests/
|   |   |   `-- Resources/
|   |   |-- Models/
|   |   |-- Services/
|   |   |-- Policies/
|   |   `-- Providers/
|   |-- bootstrap/
|   |-- config/
|   |-- database/
|   |   |-- factories/
|   |   |-- migrations/
|   |   `-- seeders/
|   |-- public/
|   |-- resources/
|   |-- routes/
|   |-- storage/
|   |   |-- app/
|   |   |-- framework/
|   |   `-- logs/
|   `-- tests/
|       |-- Feature/
|       `-- Unit/
`-- docs/
```

README files are omitted from the tree for readability.

## Intended responsibilities

- `frontend/`: Vue storefront, product browsing, customer-facing pages, and cart state.
- `backend/`: Laravel API, persistence, validation, authorization, inventory, and orders.
- `docs/`: Shared architecture, API contracts, setup notes, and deployment documentation.

## Development boundaries

Vue and Laravel were initialized separately and merged into the documented folders. Frontend dependencies live in `frontend/`; PHP dependencies live in `backend/`. The Laravel backend has no separate npm/Vite pipeline. Commit the dependency lockfiles, and keep secrets and generated dependencies out of Git.

The backend should calculate order totals and validate inventory from its own records. Keep secrets in local environment files when configuration is introduced.
