# Storefront product brief

## Confirmed direction

- MVP v1 is the first working release of the school project, retained and improved through subsequent iterations toward the graded submission. The nine published issues describe functional MVP work; the layout-only UI pass is an earlier review step.
- The first UI milestone is implemented as five barebones, responsive customer layouts with clickable navigation. The nine functional team issues remain linked in [the GitHub backlog](github-issue-drafts.md). Framework/dependency initialization and CI/Docker tooling are established separately; see [CI and Docker](ci-and-docker.md).
- This UI milestone focuses on layouts and content placement. Functional MVP behavior belongs in implementation work for the team.
- All visible copy uses lorem ipsum for layout review, including the wordmark, navigation, product details, and summaries. Nonvisual accessible labels retain meaningful control names.
- Customer screens: home, catalog, product detail with a designated 3D viewer area, cart, and checkout preview, including mobile layouts. Use static examples for relevant states rather than building a complete state system.
- Use one consistent garment fixture and placeholders. Limit interaction to navigation and presentation changes needed to review the layouts; search/filter logic, cart mutation, checkout validation, and payment simulation are later tasks.
- Track backend and other functional work in the existing GitHub issues, with acceptance criteria and dependency links.
- Initial demonstration content: thrift clothing. The niche may change.
- In MVP v1, each listing represents one unique physical garment with a fixed size, its own condition and measurements, and one unit available. Multi-size inventory and duplicate stock are outside v1's scope; later versions may revise the inventory model as requirements develop. See [the v1 listing decision](adr/0001-one-of-one-listings.md).
- Selling model: one store, rather than independent sellers in a marketplace.
- Eventual product visualization: an on-screen, rotatable 3D product viewer. For the minimal UI milestone, show a clearly labeled placeholder for this area; real model sourcing, rendering, and rotation are team backlog work. Room placement and virtual try-on are outside scope.
- The entire demo catalog contains exactly one garment listing, reused consistently across the customer screens. The eventual functional viewer will use one sample garment model. Do not add other listings or cards with a "3D preview unavailable" state.
- Team backlog scope includes both customer-facing functionality and staff tools: catalog and inventory management, product images and 3D assets, cart, orders, checkout integration, and staff access.
- Customer checkout is available to guests; customer accounts are not required.
- This is a school project. Payments are simulated or use a sandbox; no live payment collection is required.
- Checkout offers domestic shipping and pickup.
- Management access is limited to an administrator. Additional staff roles are out of scope for now. Administrator screens belong in the team backlog, outside the current customer-facing visual milestone.
- Visual direction: the user now requests copying [Bellows Film Lab](https://bellowsfilmlab.com/)'s page layout and navbar, retaining a different masthead and omitting the automatic video popup. Use white surfaces, gray image areas, a four-column desktop/two-column mobile product grid, compact captions, and the reference's section order with photo/map placeholders. Keep exactly one garment in the grid. Match the green floating Menu/Bag controls, blue Search, and separate green pill menu links; on mobile the closed navbar is a centered Menu button, with links, Bag, and Search revealed when opened.
- Apply the better-ui skill when implementing layouts. No eyebrows above headings; use solid backgrounds and simple dividers. Avoid excessive gradients, glows, heavy shadows, oversized rounded cards, decorative badges, unnecessary animation, and filler sections. Preserve normal labels, breadcrumbs, and useful product metadata.
- Vue 3/Vite/TypeScript, Vue Router, and Laravel 13 have dependency lockfiles and starter checks. Vue provides the layout preview; Laravel exposes readiness endpoints. No commerce endpoints are implemented.

## Proposed defaults for final review

- Interpret PHP as Philippine pesos and use the Philippines as the domestic market.
- Prefer an internal payment simulator for the school project, avoiding an external payment provider dependency. Never collect card details or real payments.
- For MVP v1, adding a garment to a cart does not reserve it. A successful simulated checkout atomically confirms the order and marks its listings sold out; unsuccessful checkout leaves them available. Only one order can successfully purchase a given garment. These proposed rules may be revisited as later versions' inventory requirements develop.
- Use an explicitly labeled demonstration shipping charge and pickup location until the team configures them. Pickup has no shipping charge. These are sample values, not real delivery promises.
- Use a temporary, easily replaceable store name and sample garment content; these do not establish a permanent brand or niche.
- For the later functional viewer, use one sample garment model with appropriate reuse rights and record its source. A visually accurate digital twin of a physical thrift garment is not required. No real model asset is needed for the layout milestone.

## Team implementation scope

See [the implementation spec](implementation-spec.md) and [GitHub issue backlog](github-issue-drafts.md). The first UI milestone is layout-focused. Functional storefront interactions, real 3D rendering, backend services, persisted state, administrator screens, and API integration are separate team tasks. Framework initialization and CI/Docker tooling are infrastructure setup, not completion of those features.

## Planning status

The initial layout milestone is implemented with lorem ipsum copy, one illustrated garment placeholder, static bag/checkout examples, and local image/viewer and shipping/pickup toggles. Search, filters, bag mutation, and simulated checkout remain disabled placeholders. See the [frontend guide](../frontend/README.md#layout-preview) for routes and limitations. The nine GitHub issues retain the functional MVP acceptance criteria. Framework initialization, locked dependencies, and CI/Docker tooling are established separately. Confirmed direction above remains distinct from the proposed product defaults awaiting review.
