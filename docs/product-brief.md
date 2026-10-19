# Storefront product brief

## Confirmed direction

- Current task: documentation only. Do not implement the UI, install frameworks, or publish GitHub issues yet.
- First UI milestone, when requested: minimal layouts and content placement for a clickable visual prototype. Functional behavior belongs in implementation work for the team.
- Customer screens: home, catalog, product detail with a designated 3D viewer area, cart, and checkout preview, including mobile layouts. Use static examples for relevant states rather than building a complete state system.
- Use one consistent garment fixture and placeholders. Limit interaction to navigation and presentation changes needed to review the layouts; search/filter logic, cart mutation, checkout validation, and payment simulation are later tasks.
- Prepare GitHub issues for backend and other functional work as requirements become concrete.
- Initial demonstration content: thrift clothing. The niche may change.
- Each listing represents one unique physical garment with a fixed size, its own condition and measurements, and one unit available. No multi-size inventory or duplicate stock is required.
- Selling model: one store, rather than independent sellers in a marketplace.
- Eventual product visualization: an on-screen, rotatable 3D product viewer. For the minimal UI milestone, show a clearly labeled placeholder for this area; real model sourcing, rendering, and rotation are team backlog work. Room placement and virtual try-on are outside scope.
- The entire demo catalog contains exactly one garment listing, reused consistently across the customer screens. The eventual functional viewer will use one sample garment model. Do not add other listings or cards with a "3D preview unavailable" state.
- Team backlog scope includes both customer-facing functionality and staff tools: catalog and inventory management, product images and 3D assets, cart, orders, checkout integration, and staff access.
- Customer checkout is available to guests; customer accounts are not required.
- This is a school project. Payments are simulated or use a sandbox; no live payment collection is required.
- Checkout offers domestic shipping and pickup.
- Management access is limited to an administrator. Additional staff roles are out of scope for now. Administrator screens belong in the team backlog, outside the current customer-facing visual milestone.
- Visual direction: warm minimalism, ivory and natural tones, generous spacing, clear navigation, and restrained accents.
- Apply the better-ui skill when implementing layouts. No eyebrows above headings; use solid backgrounds and simple dividers. Avoid excessive gradients, glows, heavy shadows, oversized rounded cards, decorative badges, unnecessary animation, and filler sections. Preserve normal labels, breadcrumbs, and useful product metadata.
- Repository documentation proposes a Vue storefront and Laravel API. Neither framework is initialized yet.

## Proposed defaults for final review

- Interpret PHP as Philippine pesos and use the Philippines as the domestic market.
- Prefer an internal payment simulator for the school project, avoiding an external payment provider dependency. Never collect card details or real payments.
- Adding a garment to a cart does not reserve it. A successful simulated checkout atomically confirms the order and marks its listings sold out; unsuccessful checkout leaves them available. Only one order can successfully purchase a given garment.
- Use an explicitly labeled demonstration shipping charge and pickup location until the team configures them. Pickup has no shipping charge. These are sample values, not real delivery promises.
- Retain the documented Vue storefront and Laravel API direction.
- Use a temporary, easily replaceable store name and sample garment content; these do not establish a permanent brand or niche.
- For the later functional viewer, use one sample garment model with appropriate reuse rights and record its source. A visually accurate digital twin of a physical thrift garment is not required. No real model asset is needed for the layout milestone.

## Team implementation scope

See [the implementation spec](implementation-spec.md) and [GitHub issue drafts](github-issue-drafts.md). The first UI milestone is layout-focused. Functional storefront interactions, real 3D rendering, backend services, persisted state, administrator screens, and API integration are separate team tasks. The current work only edits these plans.

## Planning status

The user's latest instruction narrows the current task to documentation and the future first UI milestone to minimal layouts and content placement. Confirmed direction above is distinct from the proposed defaults awaiting review. No application implementation or GitHub issue publication has begun; neither is authorized by this documentation-only step.
