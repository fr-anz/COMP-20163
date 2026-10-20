# database

Database schema migrations, model factories, and development seeders.

The `listings` migration stores one-of-one garment facts, integer PHP minor-unit prices, availability, and JSON measurement/media references. `DatabaseSeeder` adds the single demo garment without replacing an existing record. See [migration/seed instructions](../README.md#migrate-and-seed-the-demo-catalog) and [the API contracts](../../docs/api.md).
