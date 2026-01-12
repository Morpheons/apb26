<?php

namespace App\Models;

use App\Models\Traits\ActifTrait;
use App\Models\Traits\HasProjetTrait;
use App\Models\Traits\NewTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class avis extends Model
{
    use HasFactory,  HasProjetTrait, ActifTrait, NewTrait;
    protected $fillable = [
        'titre',
        'client',
        'description',
        'note',
        'projet_id',
        'is_actif',
        'is_new'
    ];
    public function projet(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Projets::class);
    }
}
