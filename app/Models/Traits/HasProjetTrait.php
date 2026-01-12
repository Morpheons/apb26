<?php

namespace App\Models\Traits;

use App\Models\Projets;

trait HasProjetTrait
{

    public function syncProjet($projet): array
    {
        return $this->projets()->sync($projet);
    }

    public function hasprojet($projet): bool
    {
        $projet = is_array($projet)
            ? $projet
            : explode('|', $projet);
        return $this->projets()->where('titre', $projet)->exists();
    }
    public function hasAnyprojet($projets): bool
    {
        $projets = explode('|', $projets);
        foreach ($projets as $projet) {
            if ($this->projets()->where('titre', $projet)->exists()) {
                return true;
            }
        }
        return false;
    }

}
