# frontend

Vue 3 frontend with Vite, TypeScript, and Vue DevTools. Only a framework readiness page is implemented; storefront layouts remain future work.

## Setup and commands

Use Node.js 24.12 or newer (the generated engine constraint also supports Node 22.18+).

From this folder:

```sh
npm ci
npm run dev
```

Open the URL Vite prints, normally `http://localhost:5173`. Stop it with Ctrl+C.

```sh
npm run build
npm run preview
```

`build` runs both TypeScript checking and a production build into `dist/`. `preview` serves that build locally. Commit `package-lock.json`; do not commit `node_modules/` or `dist/`.

Application source belongs in `src`; static files belong in `public`. No router, cart, API integration, or storefront design has been added.
