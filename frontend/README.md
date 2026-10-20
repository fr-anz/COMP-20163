# frontend

Vue 3 frontend with Vite, TypeScript, Vue Router, and Vue DevTools. Five responsive storefront layouts are implemented for review; commerce functionality remains in the team backlog.

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

## Layout preview

Routes use hash navigation, so direct links and refreshes work without server rewrite rules:

| Screen | URL after the Vite origin |
| --- | --- |
| Home | `/#/` |
| Catalog | `/#/shop` |
| Product detail | `/#/shop/cotton-overshirt` |
| Sample bag | `/#/bag` |
| Guest checkout preview | `/#/checkout` |

The preview follows [Bellows Film Lab](https://bellowsfilmlab.com/)'s page layout and navbar, with a different masthead and no automatic video popup. The home page follows its section order: centered shop heading/category controls, full-width product grid, three image areas, store introduction, gallery, FAQ split, and location area. Editorial photos and the map use placeholder areas. The grid has four desktop columns and two mobile columns; only its first cell contains the single sample garment.

The desktop navbar uses a green Menu button at bottom left, a blue search placeholder at bottom center, and a green Bag/count control at bottom right. Opening Menu reveals separate green pill links with circular selection markers. On mobile, only the centered Menu button shows when closed; opening it reveals wrapping green links, Bag, and Search above the button. The menu supports keyboard links, closes with Escape or when focus leaves, and links to the corresponding home sections. Motion is limited to reduced-motion-aware press feedback.

All pages reuse one sample garment from `src/fixtures/garment.ts` and an original SVG image placeholder. The product image/viewer toggle, measurements disclosure, navigation, and shipping/pickup presentation work. The 3D space and bag are static examples. Search, filters, add/remove actions, and simulated checkout are disabled. Fields are editable for layout review but are not saved or submitted.

At the user's request, all visible copy now uses lorem ipsum, including the wordmark, headings, navigation, buttons, forms, product details, and summaries. Accessible labels retain meaningful control names. The underlying garment fixture and routes remain available for later integration; prices and totals are currently shown as lorem ipsum too.

The underlying garment fixture and sample fulfillment values are demonstration data. Replace them as product decisions are confirmed. DM Sans is loaded from Google Fonts with an Arial fallback; all garment artwork is local.

Application source belongs in `src`; static files belong in `public`. No API calls, persisted state, real model rendering, administration, or payment handling is implemented. See the [implementation spec](../docs/implementation-spec.md) and [functional backlog](../docs/github-issue-drafts.md).
