<?php

namespace App\Models\Traits;

use App\Models\Coordonnee;

trait HasCoordinatesTrait
{
    public function coordinates() {
        return $this->morphOne(Coordonnee::class, 'coordonnable');
    }
}
