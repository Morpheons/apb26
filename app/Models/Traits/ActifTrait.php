<?php

namespace App\Models\Traits;


use Illuminate\Contracts\Database\Eloquent\Builder;

trait ActifTrait
{
    public function scopeActif(Builder $builder) {
        return $builder->where('is_actif', true);
    }
}
