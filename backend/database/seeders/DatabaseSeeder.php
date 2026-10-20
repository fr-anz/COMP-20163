<?php

namespace Database\Seeders;

use App\Models\Listing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Listing::query()->firstOrCreate([
            'slug' => 'cotton-overshirt',
        ], [
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
        ]);
    }
}
