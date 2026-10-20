# Implementation Spec

## Goal

Define the minimal layout-first UI milestone for a single-store thrift clothing school project. Prioritize screen structure and content placement; keep functional implementation in the team's published GitHub backlog. The five barebones layouts are now implemented following the user's request to begin prototyping. Separately requested CI/Docker infrastructure is documented in [CI and Docker](ci-and-docker.md).

## Current Behavior

The repository contains initialized Vue 3/Vite/TypeScript and Laravel 13 applications, preserved folder documentation, planning documents and a linked GitHub issue backlog, and CI/Docker tooling. Dependency manifests and lockfiles are present. Vue now provides home, catalog, product detail, sample bag, and guest checkout layouts using Vue Router hash history and one shared garment fixture. Navigation, image/viewer presentation, measurements disclosure, and shipping/pickup presentation work; commerce actions are labeled placeholders. Laravel returns readiness JSON at `/`, serves its standard health route at `/up`, and provides a repeatable one-garment database seed. CI checks Markdown, builds the Docker development image, builds/type-checks Vue, and runs Laravel tests including seed and health checks. Commerce behavior remains unimplemented. See the [frontend guide](../frontend/README.md#layout-preview) and [API contracts](api.md).

## Target Behavior

The first UI milestone provides responsive home, catalog, product detail, cart, and checkout preview layouts. The goal is to review hierarchy, spacing, content placement, and the shopping flow with minimal implementation.

The layout-only UI milestone is an early review step toward MVP v1, the first working release. The nine published issues cover functional MVP behavior, and the working application will be retained and improved through later iterations toward the graded submission. One-of-one garments, fixed sizes, and single-unit inventory define v1's scope and may be revisited as later versions' requirements develop; see [ADR 0001](adr/0001-one-of-one-listings.md).

| Screen | Required content placement |
| --- | --- |
| Home | Shared header/navigation, a clear main heading and short introduction, one sample garment visual with its name/price, and a direct shop link. |
| Catalog | Page heading, space for search/filter controls, and exactly one garment listing showing image placeholder, name, price, fixed size, and condition. Do not fill the remaining space with invented listings. |
| Product detail | Main garment image placeholder and a designated 3D viewer area, alongside name, price, fixed size, condition, measurements, and an add-to-cart action. |
| Cart | One sample line item with image, name, size, quantity of one, price, removal control placement, order summary, and checkout link. An empty-state layout can be reviewed separately. |
| Checkout preview | Guest contact fields, shipping/pickup choices, the relevant address or pickup-information area, order summary, and a clearly labeled simulated checkout action. No card-details form. |

- Reuse one sample listing and its placeholder content consistently. No multi-size selector or quantity increment controls: the garment is one of one.
- Implement only lightweight navigation and local presentation changes needed to review layouts, such as switching the shipping/pickup sections or image/viewer placeholders. Static fixture states are sufficient for cart and checkout previews.
- Search, filtering, cart mutation, form validation, payment simulation, and confirmation processing are functional backlog work. Lay out their controls without building those systems in the first UI milestone; visibly identify inactive controls rather than presenting them as working.
- The product viewer is a clearly labeled placeholder in this layout milestone. Real 3D model sourcing, rendering, loading/error handling, and mouse/touch rotation belong to a separate team task. Do not suggest that a static image is a functioning 3D model.
- No AR placement, virtual try-on, extra listings, or cards labeled "3D preview unavailable."
- No backend, API calls, persisted cart, administrator screens, or payment integration in the first UI milestone.

### Visual constraints

- Apply the `better-ui` skill when UI implementation begins. Keep its polish subordinate to the minimal layout scope.
- Follow the user's latest request to copy [Bellows Film Lab](https://bellowsfilmlab.com/)'s layout and navbar, except for the masthead and automatic video popup. Use white surfaces, dark text, gray image areas, green navigation pills, and a blue search control. Keep a different temporary wordmark.
- Reproduce the home section order: centered shop heading and compact category controls; full-width four-column desktop/two-column mobile product grid; three image areas; store introduction; gallery; FAQ split; location area; footer columns. Use lorem ipsum copy and photo/map placeholders. Keep exactly one garment in the first grid cell without inventing extra listings.
- Match the desktop navbar: Menu at bottom left, Search in the center, and Bag/count at bottom right. Opening Menu reveals separate green pill links with circular active markers, with no boxed panel. On mobile, show a centered Menu button when closed; reveal wrapping pill links including Bag, plus Search above the button, when opened. Preserve Escape, keyboard links, section navigation, and page-end clearance.
- No eyebrows: do not place small promotional/category labels above headings. Normal breadcrumbs, form labels, and useful garment metadata remain appropriate.
- Use solid backgrounds for this pass. Avoid excessive gradients, decorative glows, heavy shadows, oversized rounded cards, bento grids, redundant badges, and repeated boxed sections.
- Use whitespace and simple dividers to group content. The requested reference sections use barebones placeholders for placement review; do not add unrelated statistics, trust strips, or additional sections.
- Avoid unnecessary motion. If interaction transitions are introduced, name the changing properties, gate movement behind reduced-motion preferences, and use the skill's exact enabled-button press value of `0.96` over `150ms` with `ease-out`.
- Keep any icons consistent, outlined by default, and colored with `currentColor`. Restrict hover-only styling to hover-capable pointers; preserve visible keyboard focus.
- The user requests lorem ipsum for all visible copy, including navigation, headings, form labels, product details, and summaries. Keep meaningful nonvisual accessible labels and working presentation toggles.
- Use temporary brand/copy and image placeholders. Custom illustration, photography, asset acquisition, and a detailed design system are not required to review these layouts.

## Relevant Files

This spec, `docs/product-brief.md`, and `docs/github-issue-drafts.md` define the layout scope and functional backlog. `GLOSSARY.md` and `docs/adr/` retain agreed domain language and decisions.

Layout implementation uses:

- `frontend/README.md`, `frontend/package.json`, and framework configuration: retain the existing minimal Vue setup and its start/build instructions.
- `frontend/src/pages/` and `frontend/src/layouts/`: the five customer screens and shared shell.
- `frontend/src/components/common/`, `catalog/`, and `cart/`: only small components needed by the layouts.
- `frontend/src/router/`: navigation between layout previews.
- `frontend/src/fixtures/garment.ts`: the single demonstration garment shared by all pages.
- `frontend/src/assets/` and `frontend/public/`: simple placeholder assets if needed.

Stores, API services, real model assets, and `backend/` belong to later functional tasks. Do not create them speculatively for layout review.

## Files To Avoid

- The user authorized the barebones layout implementation. This milestone does not authorize functional backlog items. Framework/dependency initialization is established and the nine GitHub issues are already published; do not recreate them.
- During layout work, do not initialize the backend or implement functional backlog items.
- Do not modify `.git/`, unrelated global settings, or unrelated repository documentation.
- Do not add live payment configuration, customer accounts, marketplace features, additional staff roles, or extra demo listings.

## Assumptions

PHP means Philippine pesos; the domestic market is the Philippines; and payments use an internal simulator, as confirmed for issue #1. Vue/Laravel are initialized. A temporary brand, sample shipping charge, and pickup location must be clearly identified as demonstration content. Functional backend contracts are recorded in [the API agreement](api.md).

For the backend backlog, cart membership does not reserve inventory and successful simulated checkout atomically sells each garment. A competing checkout must fail without confirming a second order or charging anything. Real 3D model sourcing and its rendering library are later implementation choices, subject to reuse rights and compatibility checks. These decisions do not need implementation to review content placement.

## Step-by-Step Implementation

1. Keep layout review separate from functional MVP implementation. The team issues are already published; use their existing links in the backlog.
2. Use the existing Vue setup in `frontend/` and its documented start/build commands; do not run a new framework generator over it.
3. Establish the shared header, navigation, footer, type hierarchy, spacing, and restrained visual treatment using the constraints above.
4. Lay out the five screens using the same single garment fixture. Prioritize product facts, primary actions, and summaries over decorative sections.
5. Add lightweight links and presentation toggles needed for review. Use placeholder imagery and a clearly labeled viewer area; use static cart/checkout examples instead of implementing commerce logic.
6. Review desktop/mobile placement, readable text, keyboard access, focus visibility, and overflow. Fix layout issues without expanding into functional work.
7. Track remaining functions in the published GitHub issues and preserve their dependency links. Assign or update existing issues as the team takes on work rather than creating duplicates.

## Edge Cases

- Long garment names and measurements must wrap without colliding with prices or actions.
- Exactly one catalog item should look intentional; do not pad the grid with additional products or repetitive placeholder cards.
- A narrow viewport must keep product facts, the primary action, and the checkout summary readable without horizontal scrolling.
- Fixed size and quantity must be presented as facts rather than interactive multi-stock controls.
- Shipping and pickup previews must make their different information needs clear.
- Static controls and the viewer placeholder must not imply completed functionality or a real transaction.
- No-match, empty-cart, model-error, validation, and payment-result behavior are later functional acceptance criteria, not a reason to build a full state system during layout review.

## Testing Checklist

For scope reconciliation:

- Confirm that the brief, this spec, and linked GitHub backlog agree about layout-first scope and deferred functionality.
- Confirm that layout work introduces no functional commerce behavior or duplicate issues. Framework scaffolds, dependencies, and issue publication have been requested separately.

For layout implementation and revisions:

- Run the documented frontend build and manually inspect all five screens on desktop and mobile.
- Check content order, spacing, long-text wrapping, overflow, clear actions, and consistent placeholder garment data.
- Follow navigation and any presentation toggles with keyboard and pointer; verify visible focus and useful form labels.
- Verify the absence of eyebrows, decorative gradients/glows, excessive cards/badges, unnecessary animation, and unrequested filler sections.
- Confirm the viewer is visibly a placeholder and no actual payment, cart persistence, customer sign-in, or API is needed to review the screens.
- Do not add tests that only mirror static markup. Functional tests, model interaction checks, and backend concurrency tests belong to the later team tasks.

## Handoff Prompt for Implementer

Use this spec, `docs/product-brief.md`, and `GLOSSARY.md` to review and refine the implemented barebones layouts. Vue and Laravel scaffolds, dependencies, and CI are already set up; do not regenerate them. The nine team issues are already published; use their existing links in `docs/github-issue-drafts.md` rather than recreating them. Keep five responsive customer layouts with one sample thrift garment, placeholder imagery and a labeled 3D viewer area, simple navigation, and shipping/pickup presentation. The latest direction is to copy the supplied Bellows Film Lab page layout and navbar, keeping a different masthead and omitting the automatic video popup. Follow the detailed visual constraints above, including its section order and desktop/mobile navigation. Apply better-ui with no eyebrows, solid backgrounds, and minimal motion. Leave search/filter logic, cart behavior, validation, actual model rendering/rotation, simulated payments, backend services, and administration to the team backlog. Run only checks appropriate to the stage being performed.
