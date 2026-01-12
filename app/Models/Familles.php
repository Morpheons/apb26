<?php

namespace App\Models;

use App\Models\Traits\ActifTrait;
use App\Models\Traits\HasFamilleTrait;
use App\Models\Traits\NewTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Familles extends Model
{
    use HasFactory,  HasFamilleTrait, ActifTrait, NewTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titre',
        'slug',
        'labeltext',
        'image',
        'fond',
        'description',
        'is_actif',
        'is_new'
    ];
    public function projets(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Projets::class);
    }
}
