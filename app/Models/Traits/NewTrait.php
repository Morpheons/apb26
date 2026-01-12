<?php

namespace App\Models\Traits;

use Illuminate\Contracts\Database\Eloquent\Builder;
trait NewTrait
{
    public function scopeNew(Builder $builder) {
        return $builder->where('is_new', true);
    }
}
