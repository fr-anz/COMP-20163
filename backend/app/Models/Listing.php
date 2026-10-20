<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'price_minor' => 'integer',
            'measurements' => 'array',
            'photos' => 'array',
            'model' => 'array',
        ];
    }
}
