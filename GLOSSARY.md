# Storefront

Language for a single store's shopping experience, initially demonstrated with thrift clothing.

## Language

**Storefront**:
The customer-facing presentation of the store's catalog and shopping journey.
_Avoid_: Marketplace

**Demo Catalog**:
A collection of sample items used to demonstrate the storefront. Its initial thrift clothing theme does not establish the store's permanent niche.

**Listing**:
An offer to sell one unique physical garment, with its own size and condition. A listing has one unit available and becomes sold out when that garment is sold.
_Avoid_: Multi-size product, replenishable product

**Guest Checkout**:
A purchase flow that does not require the shopper to create or sign in to a customer account.

**Administrator**:
The store operator authorized to manage listings, their images and models, availability, and orders. This is the only management role currently in scope.
_Avoid_: Seller, staff role

**3D Product Viewer**:
An on-screen presentation of a product model that a shopper can rotate to inspect its appearance.
_Avoid_: AR listing, virtual try-on

**Simulated Payment**:
A demonstration of a payment result without collecting or moving real money.
_Avoid_: Live payment

**Shipping**:
Delivery of a purchased garment to a customer's address within the store's domestic delivery area.

**Pickup**:
Collection of a purchased garment by the customer at the store's designated pickup location.
