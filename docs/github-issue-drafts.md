# GitHub issue drafts

These nine issues are prepared for `fr-anz/COMP-20163`. They cover future team work; the first layout-focused UI milestone is described in [the implementation spec](implementation-spec.md). The current request is documentation only: do not publish issues or start implementation. When publication is requested, use the existing `enhancement` label, leave assignees unset, and replace draft dependency references with actual GitHub issue links.

The initial layouts provide placeholders and light navigation only. Functional search/filtering, cart updates, checkout validation, payment simulation, and real model rendering are assigned below rather than assumed to exist already. Preserve the layout milestone's better-ui constraints when adding functionality: no eyebrows, restrained solid surfaces, and no decorative visual filler.

PHP/Philippines, the internal simulator, and the exact inventory-allocation timing remain proposed defaults in [the product brief](product-brief.md); resolve them before implementing the affected tasks. The accepted scope already includes one-of-one listings, guest checkout, simulated/sandbox payments, domestic shipping, pickup, and administrator-only management.

## 1. Initialize the Laravel API and document storefront contracts

The backend currently contains folder documentation only. Initialize a runnable Laravel API and document the minimum contracts that let frontend and backend work proceed independently.

Likely files: `backend/` framework/configuration files, `.env.example`, migrations and seeders, `backend/README.md`, and `docs/api.md`. Avoid changing customer layouts.

Acceptance criteria:

- A documented local setup starts the API against a supported local database; credentials are excluded from version control.
- Document request/response examples for catalog, cart, fulfillment options, guest checkout, orders, and administrator access, including validation and unavailable-item errors.
- Prices use PHP and integer minor units at the API boundary. The backend calculates authoritative totals.
- Seed exactly one demo garment. Its fixed size, condition, measurements, price, availability, photos, and sample model reference are represented.
- State the selected database and authentication approach so dependent tasks can implement against them.
- Setup and basic API health are verified, with repeatable database migration/seed instructions.

Dependencies: none.

## 2. Implement administrator authentication and protect management endpoints

Only an administrator manages the store. Add administrator sign-in/sign-out without public customer registration or additional staff roles.

Likely files: `backend/app/Http/`, policies, authentication configuration, routes, administrator seed/setup instructions, and feature tests.

Acceptance criteria:

- Administrator credentials can be provisioned securely for local school-project use; secrets are not committed.
- Login failures and logout are handled correctly; unauthenticated requests cannot manage listings, assets, or orders.
- Guest catalog and checkout access remain available without a customer account.
- API tests cover permitted and forbidden access, invalid login, and session/token invalidation on logout.

Dependencies: draft 1.

## 3. Implement one-of-one listings, catalog queries, and administrator asset management

Implement catalog persistence and protected management of unique thrift garments and their photos/sample 3D assets. A listing is one physical garment, not a product with size variants.

Likely files: `backend/app/Models/`, controllers, requests, resources, policies, storage configuration, migrations, and catalog feature tests.

Acceptance criteria:

- Administrator can create, edit, and archive listings with one fixed size, condition, measurements, PHP price, and availability.
- Public API supports listing/detail retrieval and the search/filter controls placed in the initial layouts.
- A listing cannot have multiple available units. Sold or referenced listings retain the data needed by existing orders.
- Administrator can attach permitted image/model files; validate file type and size, protect write operations, and document supported asset requirements.
- Responses supply usable media references. Asset source/license attribution can be retained for demonstration content.
- Exactly one demo listing is seeded; tests may create additional fixtures solely to exercise behavior.
- Tests cover invalid fields/media, authorization, filtering, and one-unit constraints.

Dependencies: drafts 1 and 2.

## 4. Implement guest cart persistence with one-unit constraints

Implement a guest cart that can survive refresh without requiring a customer account. The initial UI provides a static cart layout, not an existing functional cart.

Likely files: backend cart models/services/controllers/routes and cart feature tests. Document the agreed cart identifier/session contract in `docs/api.md`.

Acceptance criteria:

- A guest can retrieve the cart, add the garment, and remove it. Repeated adds never create quantity above one.
- Cart identity is isolated between guests and does not expose another guest's data.
- Cart membership does not reserve inventory. Responses identify stale or sold-out contents for correction before checkout.
- Prices and totals come from server records, never trusted client values.
- Tests cover persistence, guest isolation, repeated adds, removal, and stale availability.

Dependencies: drafts 1 and 3.

## 5. Add domestic shipping and pickup options with server-calculated totals

Support the two agreed fulfillment methods with configurable demonstration values rather than live carrier integrations.

Likely files: backend fulfillment configuration/services, checkout validation, API resources, and feature tests.

Acceptance criteria:

- API exposes shipping and pickup options for the agreed domestic market, with PHP-denominated demonstration fees.
- Shipping requires the documented domestic delivery fields; pickup supplies a configured collection location and requires no shipping address.
- Pickup adds no shipping fee. The backend calculates the chosen method's total and rejects tampered fees or unsupported methods.
- Customer-facing responses clearly identify demonstration delivery values; no real carrier booking or delivery promises are made.
- Tests cover both methods, conditional address validation, and total calculations.

Dependencies: draft 1. Coordinate fields with drafts 4 and 6.

## 6. Implement simulated guest checkout and prevent duplicate garment sales

Create orders using a school-project payment simulator. Never collect card details or move real money. Enforce the unique-garment inventory rule even when two guests attempt checkout together.

Likely files: backend order/payment-simulation services, models, migrations, checkout requests/controllers/resources, and feature/integration tests.

Acceptance criteria:

- Validate a nonempty guest cart, relevant customer/contact details, fulfillment choice, availability, and server-calculated totals.
- A controlled simulator demonstrates successful and failed payments without an external payment provider or real card entry.
- Successful simulated checkout atomically creates a confirmed order and sells its garments. Failed checkout does not sell inventory.
- Competing checkouts cannot confirm two orders for the same garment; return an actionable unavailable-item response to the losing request.
- Repeating the same checkout submission does not create a second order.
- Preserve the garment description, agreed price, fulfillment details, and total on the order, even if the listing later changes.
- Restrict guest order access using an appropriately scoped opaque confirmation mechanism; do not expose orders through guessable identifiers alone.
- Tests cover success/failure, empty/stale carts, tampered prices, duplicate submissions, concurrent purchase attempts, and guest order privacy.

Dependencies: drafts 3, 4, and 5.

## 7. Build administrator screens for catalog, assets, and orders

Give the administrator a minimal interface to maintain the school project's catalog and inspect orders. These screens are separate from the initial five customer layouts.

Likely files: `frontend/src/pages/`, administrator layouts/components, router guards, services, and relevant integration checks.

Acceptance criteria:

- Provide administrator login/logout and protected routes, with backend authorization remaining authoritative.
- Provide listing creation/edit/archive, image/model attachment, availability display, and useful validation messages.
- Provide an order list/detail view showing simulated payment result and shipping/pickup details without introducing unspecified fulfillment workflows.
- Handle loading, empty, unauthorized, and API-error states.
- Do not add customer registration, marketplace sellers, or employee roles.
- Verify an administrator can update a listing and inspect a simulated order; verify guests cannot access protected data or operations.

Dependencies: drafts 2, 3, and 6.

## 8. Implement storefront interactions and connect the customer layouts to APIs

Add the functional behavior intentionally deferred from the initial layouts, using the team's APIs while preserving the agreed content placement, restrained styling, and single demo listing.

Likely files: `frontend/src/services/`, stores, composables, customer pages, 3D viewer component, and relevant integration checks.

Acceptance criteria:

- Home/catalog/detail use API listing data and the listing's image/model references. Connect the functional viewer from draft 9 to the product detail layout.
- Make the laid-out search/filter controls functional, including a no-match state and reset without inventing more demo listings.
- Cart refresh/add/remove use the guest-cart contract and preserve the one-unit rule.
- Implement checkout field validation, API fulfillment choices, conditional fields, authoritative totals, and the simulated payment/order flow.
- Show loading/errors, no-match/empty cart, stale availability, duplicate-submit protection, and shipping/pickup confirmation states.
- Do not invent extra demo listings or advertise "3D preview unavailable" cards. A transient viewer load failure offers retry without breaking shopping navigation.
- Payments remain clearly labeled as simulated, with no real card fields or live-payment calls.
- Verify complete shipping and pickup journeys, refresh behavior, failure recovery, and a competing checkout that sells the only garment first.

Dependencies: drafts 3, 4, 5, 6, and 9; the initial customer layouts must exist.

## 9. Replace the product viewer placeholder with a rotatable sample garment model

The initial product detail screen reserves space for a viewer without loading a real model. Implement on-screen model inspection as a separate functional task; no AR placement or virtual try-on is required.

Likely files: `frontend/src/components/catalog/`, the product detail page, sample model assets, and asset attribution documentation. Coordinate the supported model format with draft 3.

Acceptance criteria:

- Load one reusable sample garment model with documented source and reuse rights. A digital twin of a real thrift item is not required.
- Replace the labeled viewer placeholder with actual model rendering and mouse/touch rotation. A static image or flat image rotation does not fulfill this task.
- Provide an accessible way to adjust the view, plus usable loading, retry/error, and reset-view controls; preserve the rest of the product page if loading fails.
- Keep the same single listing. Do not introduce additional listings or cards announcing unavailable 3D previews.
- Avoid decorative entrance animations or auto-rotation; honor reduced-motion preferences for any optional movement.
- Verify model loading, pointer/touch and keyboard controls, reset, load failure, and responsive placement.

Dependencies: the product detail layout and an agreed sample asset/format. Development can begin with a local asset; API-provided references are connected in draft 8 after draft 3.
