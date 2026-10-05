# E-Commerce

A documentation-only folder scaffold for an e-commerce application using Vue.js for the storefront and Laravel for the backend API.

Every folder contains a README describing its purpose. No application code, dependencies, package manifests, or generated framework files are included.

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

## Future initialization

When implementation begins, initialize Vue and Laravel separately and merge their generated files into the corresponding folders. Use temporary directories for framework generators that require an empty destination. Replace folder READMEs as needed while retaining useful project documentation.

The backend should calculate order totals and validate inventory from its own records. Keep secrets in local environment files when configuration is introduced.
