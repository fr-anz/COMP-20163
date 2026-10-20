<?php

namespace Tests\Feature;

use App\Models\Listing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DemoCatalogSeedTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seed_creates_one_demo_garment_without_user_credentials(): void
    {
        $this->artisan('db:seed')->assertSuccessful();

        $this->assertDatabaseCount('listings', 1);
        $this->assertDatabaseCount('users', 0);

        $listing = Listing::query()->sole();

        $this->assertSame([
            'slug' => 'cotton-overshirt',
            'name' => 'Cotton overshirt',
            'description' => 'Sample thrift garment for the school-project catalog.',
            'category' => 'tops',
            'size' => 'M',
            'condition' => 'Good, gently worn',
            'color' => 'Sand',
            'material' => '100% cotton',
            'measurements' => ['unit' => 'cm', 'chest' => 56, 'length' => 72, 'sleeve' => 59],
            'currency' => 'PHP',
            'price_minor' => 85000,
            'availability' => 'available',
            'photos' => [[
                'reference' => 'demo-overshirt-front',
                'url' => null,
                'alt' => 'Front view of the sample cotton overshirt',
                'status' => 'placeholder',
            ]],
            'model' => [
                'reference' => 'demo-overshirt-model',
                'url' => null,
                'format' => 'glb',
                'status' => 'placeholder',
                'source' => null,
                'license' => null,
            ],
        ], $listing->only([
            'slug', 'name', 'description', 'category', 'size', 'condition', 'color', 'material',
            'measurements', 'currency', 'price_minor', 'availability', 'photos', 'model',
        ]));
    }

    public function test_reseeding_does_not_duplicate_the_garment_or_overwrite_existing_data(): void
    {
        $this->artisan('db:seed')->assertSuccessful();

        $listing = Listing::query()->sole();
        $listing->availability = 'sold';
        $listing->price_minor = 90000;
        $listing->save();

        $this->artisan('db:seed')->assertSuccessful();

        $this->assertDatabaseCount('listings', 1);
        $this->assertDatabaseCount('users', 0);
        $this->assertSame('sold', $listing->fresh()->availability);
        $this->assertSame(90000, $listing->fresh()->price_minor);
    }
}
