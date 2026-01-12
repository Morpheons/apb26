<?php

namespace App\Models;

use App\Models\Traits\ActifTrait;
use App\Models\Traits\HasFamilleTrait;
use App\Models\Traits\NewTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projets extends Model
{
    use HasFactory,  HasFamilleTrait, ActifTrait, NewTrait;

    public function scopeActifs($query)
    {
        return $query->where('is_actif', true);
    }

    protected $fillable = [
        'titre',
        'slug',
        'labeltext',
        'image',
        'description',
        'familles_id',
        'is_actif',
        'is_new'
    ];
    public function famille(): \Illuminate\Database\Eloquent\Relations\BelongsTo    {
        return $this->belongsTo(Familles::class, 'familles_id');
    }
    public function avis(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Avis::class);
    }
}
