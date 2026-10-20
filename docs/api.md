# Storefront API contracts — MVP v1

This document defines the application programming interface (API) shared by the Vue and Laravel teams for [issue #1](https://github.com/fr-anz/COMP-20163/issues/1). The contracts below describe the target behavior for dependent issues. Only `GET /` and `GET /up` are implemented now. The listing schema and demo seed are database foundations, not working commerce endpoints.

The user confirmed PHP, local Philippine shipping, and an internal payment simulator for issue #1. A successful simulated checkout records the purchase and sells the garment; the contracts below specify the atomic operation and retry behavior for issue #6.

## Shared rules

- Application routes use `/api/v1`. Send `Accept: application/json` and, for JSON bodies, `Content-Type: application/json`.
- Successful object responses use `{"data": {...}}`; collections use `data` plus pagination `meta`. `204 No Content` responses have no body. Framework health responses keep their existing format.
- Money uses currency `PHP` (Philippine pesos) and integer minor units: `85000` means ₱850.00. Never send floating-point prices. The server reads prices and fees from its own records and calculates all totals. Guest cart/checkout requests cannot set prices, fees, quantities, or totals (`422`); authorized administrator listing writes set the stored garment price.
- A listing represents one garment with one fixed size. Availability is `available`, `sold`, or `archived`; there is no multi-unit quantity field. Adding to a cart does not reserve it.
- IDs are JSON integers for listings and opaque strings for orders. Timestamps, when returned, use ISO 8601 in UTC. Do not depend on the demo listing having ID `1`; find it by slug.
- The domestic country is `PH`. The payment method is `simulated`; the simulator moves no money and accepts no card details. Successful checkout confirms the order and marks its garments sold in one database transaction. Failed checkout leaves inventory unchanged.
- Shipping fees and pickup locations shown here are explicitly labeled demonstration values. Issue #5 makes them configurable. The production database remains undecided; development uses SQLite and tests use in-memory SQLite.

## Sessions and access

Use Laravel Sanctum's cookie-based session authentication for the first-party Vue application. Issue #2 installs/configures Sanctum; it is not installed by issue #1. Use the same host locally (`localhost:5173` and `localhost:8000`), credentials-enabled requests, an explicit allowed frontend origin, and stateful API/session middleware. Deployed frontend/API hosts must share a top-level domain. Do not store administrator bearer tokens in browser storage.

Before login or guest state changes, call `GET /sanctum/csrf-cookie`. Send the resulting `XSRF-TOKEN` cookie value in the `X-XSRF-TOKEN` header on state-changing requests, and include cookies with all session requests. This protects against cross-site request forgery (CSRF), where another site attempts to submit a request using the browser's cookies. A missing/expired CSRF token returns `419`; initialize CSRF again before retrying a safe action.

Issue #4 binds the guest cart to the server session. The client sends no cart ID, user ID, or guest token. A new session gets an empty cart; the same session survives refresh until expiry. Administrator login rotates the session ID while retaining the guest cart. Logout invalidates the session, so its guest cart/order access also expires. A new session must never inherit the previous session's data.

Guest orders are accessible only to their originating guest session through an opaque order ID. A different session or nonexistent ID gets `404`. Public catalog reads require no login. Every management route requires an authenticated, explicitly authorized administrator; authentication alone does not grant management access. There are no public registration endpoints or customer/staff accounts. Issue #2 provisions administrators through a local command with a prompted secret, not committed seed credentials.

This approach follows [Laravel's Sanctum SPA authentication guidance](https://github.com/laravel/docs/blob/13.x/sanctum.md#spa-authentication). Issue #2 owns session, CSRF, allowed-origin configuration, login throttling, and authorization tests; issue #4 applies the same session/CSRF rules to guest cart routes.

## Health — implemented

`GET /` → `200`:

```json
{"name": "E-Commerce API", "status": "ready"}
```

`GET /up` → `200` when Laravel boots successfully, or `500` on a boot failure. With `Accept: application/json`, the healthy response is `{"status": "up"}`; a normal browser request gets the framework's health page. This checks application health, not catalog/database readiness. Neither route needs authentication.

## Catalog — issue #3

| Request | Result |
| --- | --- |
| `GET /api/v1/listings?q=cotton&category=tops&size=M&condition=Good%2C%20gently%20worn&page=1&per_page=12` | `200`, matching available listings. All filters are optional; `q` is a case-insensitive name/description search, the other filters match stored values. |
| `GET /api/v1/listings/cotton-overshirt` | `200`, one available or sold listing; archived/missing slug returns `404`. |

Search text is at most 100 characters; category/size/condition filters at most 50/30/100. `page` is an integer ≥1; `per_page` is an integer from 1–48, default 12. Invalid query parameters return `422`. No matches return `data: []`, with `total: 0` and `last_page: 1`. Out-of-range pages return an empty array with the actual pagination metadata. Sold listings stay retrievable by slug for stale-cart recovery but are excluded from the public collection.

Collection response (IDs in examples are illustrative):

```json
{
  "data": [{
    "id": 1,
    "slug": "cotton-overshirt",
    "name": "Cotton overshirt",
    "description": "Sample thrift garment for the school-project catalog.",
    "category": "tops",
    "size": "M",
    "condition": "Good, gently worn",
    "color": "Sand",
    "material": "100% cotton",
    "measurements": {"unit": "cm", "chest": 56, "length": 72, "sleeve": 59},
    "currency": "PHP",
    "price_minor": 85000,
    "availability": "available",
    "photos": [{"reference": "demo-overshirt-front", "url": null, "alt": "Front view of the sample cotton overshirt", "status": "placeholder"}],
    "model": {"reference": "demo-overshirt-model", "url": null, "format": "glb", "status": "placeholder", "source": null, "license": null}
  }],
  "meta": {"current_page": 1, "per_page": 12, "last_page": 1, "total": 1}
}
```

The detail response wraps the same listing object in `data`, without pagination. The seed represents one photo and one sample model reference with `url: null` and `status: placeholder`. These are not downloadable assets. Issues #3/#9 replace the placeholders with permitted assets and usable URLs, retain source/license attribution, and use `status: ready`. GLB is the proposed sample model format to coordinate in those issues. Do not invent extra listings to demonstrate missing assets.

## Guest cart — issue #4

| Request | Result |
| --- | --- |
| `GET /api/v1/cart` | `200`, the current session's cart, creating an empty one if necessary. |
| `POST /api/v1/cart/items` with `{"listing_id": 1}` | `200`, the updated cart; repeating the add leaves one unit. |
| `DELETE /api/v1/cart/items/1` | `200`, the updated cart; removing an absent item is also successful. |

`listing_id` must be an existing integer ID (`422` otherwise). Adding a sold/archived listing returns `409 listing_unavailable`. A cart read keeps stale items visible, marks their current availability, and lists their IDs in `unavailable_listing_ids`. Removing a stale item is allowed. No client quantity/price/total fields are accepted.

```json
{
  "data": {
    "items": [{"listing_id": 1, "slug": "cotton-overshirt", "name": "Cotton overshirt", "size": "M", "quantity": 1, "currency": "PHP", "unit_price_minor": 85000, "line_total_minor": 85000, "availability": "available"}],
    "currency": "PHP",
    "subtotal_minor": 85000,
    "unavailable_listing_ids": []
  }
}
```

An empty cart has `items: []`, `subtotal_minor: 0`, and `unavailable_listing_ids: []`. Subtotal includes all visible cart lines at current server prices; it is not a reservation or checkout guarantee. Fulfillment and checkout must recheck availability and prices.

## Fulfillment options — issue #5

`GET /api/v1/fulfillment-options` → `200` for the current guest cart:

```json
{
  "data": {
    "currency": "PHP",
    "country_code": "PH",
    "is_demo": true,
    "subtotal_minor": 85000,
    "unavailable_listing_ids": [],
    "options": [
      {"method": "shipping", "label": "Demo domestic shipping", "fee_minor": 10000, "total_minor": 95000, "requires_address": true},
      {"method": "pickup", "label": "Demo store pickup", "fee_minor": 0, "total_minor": 85000, "requires_address": false, "pickup_location": {"name": "Demo pickup point", "address": "Sample campus collection point; confirm with the project team."}}
    ]
  }
}
```

The shipping fee above is ₱100.00 and pickup is free. Empty carts use subtotal zero and the same fee information; checkout still rejects empty carts. Stale carts expose `unavailable_listing_ids` as above. Totals are current quotes, recalculated at checkout. No carrier booking or delivery-time promise is made.

## Guest checkout and orders — issue #6

`POST /api/v1/checkout` requires an `Idempotency-Key` header containing a UUID generated once per submission attempt. Idempotency means retrying the same request does not create another order. Scope the key to the guest session and retain its result for at least the session lifetime. The same key/body replays the result (`200` for a prior success, the original error status for a prior failure); a changed body returns `409 idempotency_conflict`. Check for a replay before revalidating the now-empty cart. Use a new key when changing fields or retrying a declined simulation.

Shipping request:

```json
{
  "contact": {"name": "Alex Example", "email": "alex@example.test", "phone": "09171234567"},
  "fulfillment": {
    "method": "shipping",
    "address": {"line1": "123 Sample Street", "line2": null, "city": "Manila", "province": "Metro Manila", "postal_code": "1000", "country_code": "PH"}
  },
  "payment": {"method": "simulated", "outcome": "approved"}
}
```

Pickup uses the same contact/payment objects and `"fulfillment": {"method": "pickup"}`. Do not send an address for pickup. To demonstrate failure, send `"outcome": "declined"`; return `422 payment_declined` with no confirmed order or inventory change. The outcome control is only for the school-project simulator.

Validation:

- The session cart must contain at least one available item. Empty cart returns `422 empty_cart`; a sold/archived item returns `409 listing_unavailable`.
- Contact name (1–100 characters), valid email (≤254), and phone (7–30 characters, digits with optional spaces, `+`, `-`, parentheses) are required.
- Shipping requires line1 (≤200), city/province (≤100 each), a four-digit Philippine postal code, and `country_code: PH`. Optional line2 is nullable and ≤200. Strings must be nonblank after trimming. Pickup prohibits address fields.
- Fulfillment method is `shipping` or `pickup`. Payment method is `simulated`; outcome is `approved` or `declined`. Missing/invalid idempotency keys and unrecognized request fields return `422`. Client prices, fees, totals, card details, and customer IDs are prohibited.
- The server recalculates totals, checks availability, creates an immutable order snapshot, and marks the purchased listings sold atomically. Two competing approvals cannot sell the same garment. A losing request returns `409 listing_unavailable` and creates no confirmed order.

Success → `201`:

```json
{
  "data": {
    "id": "07d6194e-7bea-4ee9-a82a-4ed2bf88c5e7",
    "status": "confirmed",
    "placed_at": "2026-10-20T04:00:00Z",
    "contact": {"name": "Alex Example", "email": "alex@example.test", "phone": "09171234567"},
    "items": [{"listing_id": 1, "name": "Cotton overshirt", "size": "M", "condition": "Good, gently worn", "measurements": {"unit": "cm", "chest": 56, "length": 72, "sleeve": 59}, "quantity": 1, "unit_price_minor": 85000, "line_total_minor": 85000}],
    "currency": "PHP",
    "subtotal_minor": 85000,
    "fulfillment": {"method": "shipping", "fee_minor": 10000, "is_demo": true, "address": {"line1": "123 Sample Street", "line2": null, "city": "Manila", "province": "Metro Manila", "postal_code": "1000", "country_code": "PH"}},
    "total_minor": 95000,
    "payment": {"method": "simulated", "status": "approved", "is_demo": true}
  }
}
```

For pickup, the order fulfillment object contains `method: pickup`, `fee_minor: 0`, `is_demo: true`, and the configured `pickup_location` snapshot; it contains no address. An approved purchase clears the purchased lines from the guest cart. Preserve the order's garment facts, prices, contact, fees, and fulfillment details even if the live listing/configuration later changes.

`GET /api/v1/orders/{opaque-order-id}` → `200` with the same saved order object for its originating session, or `404` otherwise. There is no public order list or email-based lookup. Session expiry loses guest access; administrator order access remains available through protected routes. Issue #6 must test session isolation, repeated submissions, and competing purchases.

## Administrator access — issues #2, #3, #7

After initializing CSRF cookies, `POST /api/v1/admin/login` with:

```json
{"email": "admin@example.test", "password": "<locally provisioned secret>"}
```

Success → `200`, rotates the session ID and returns:

```json
{"data": {"id": 1, "name": "Store administrator", "email": "admin@example.test"}}
```

These example values do not create an account. Require email/password, return generic `422` field errors for invalid credentials without disclosing whether an email exists, and throttle repeated attempts (`429`). `GET /api/v1/admin/me` returns the same administrator object or `401`. `POST /api/v1/admin/logout` requires the authenticated session and CSRF header, invalidates the session, and returns `204`.

Protected management route plan:

| Route | Target behavior | Owner |
| --- | --- | --- |
| `GET /api/v1/admin/listings` | Paginated listings including sold/archived items. | #3 |
| `POST /api/v1/admin/listings` | Create one garment from validated listing fields, `201`. | #3 |
| `PATCH /api/v1/admin/listings/{id}` | Update permitted fields, `200`; sold order snapshots stay unchanged. | #3 |
| `DELETE /api/v1/admin/listings/{id}` | Archive without deleting referenced history, `204`. | #3 |
| `POST /api/v1/admin/listings/{id}/photos` | Attach a validated image file using multipart form data. | #3 |
| `PUT /api/v1/admin/listings/{id}/model` | Attach a validated sample model using multipart form data. | #3/#9 |
| `GET /api/v1/admin/orders` | Paginated saved orders. | #6/#7 |
| `GET /api/v1/admin/orders/{opaque-order-id}` | Saved order detail. | #6/#7 |

All these routes return `401` for no authenticated session and `403` for an authenticated user without administrator permission. Issue #3 defines field/media limits and extends these write examples before implementing uploads. It must not accept arbitrary caller-provided file paths. These routes are a coordination plan, not existing endpoints.

## Errors

Errors use a stable machine-readable `code` and a readable `message`. Validation errors also include field-keyed `errors`. Business errors may include affected `listing_ids`. Unknown fields in JSON write requests are rejected. Do not show stack traces, passwords, session IDs, or another guest's order data.

`422` validation example:

```json
{
  "message": "The submitted data is invalid.",
  "code": "validation_failed",
  "errors": {"contact.email": ["A valid email address is required."], "fulfillment.address.country_code": ["Shipping is available only within PH."]}
}
```

`409` unavailable-item example:

```json
{"message": "A garment is no longer available. Remove it from your cart before trying again.", "code": "listing_unavailable", "listing_ids": [1]}
```

Other documented errors use the same envelope: `401 unauthenticated`, `403 forbidden`, `404 not_found`, `409 idempotency_conflict`, `419 csrf_expired`, `422 empty_cart`, `422 payment_declined`, and `429 too_many_requests`. Invalid login uses `422 validation_failed` with a generic email error. Issue #2 establishes the common JSON error rendering for application routes. Health routes retain framework responses.

## Implementation handoff

Issue #1 provides this agreement and the persisted seed. Issues #2–#6 implement the routes in dependency order; #7/#8 connect the layouts; #9 supplies the model. Update these examples alongside intentional contract changes. Do not treat a documented route as available until its owning issue implements and tests it.
