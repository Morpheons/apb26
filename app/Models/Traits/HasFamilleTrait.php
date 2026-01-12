<?php

namespace App\Models\Traits;

use App\Models\Familles;

trait HasFamilleTrait
{

    public function syncFamille($famille): array
    {
        return $this->familles()->sync($famille);
    }

    public function hasFamille($famille): bool
    {
        $famille = is_array($famille)
            ? $famille
            : explode('|', $famille);
        return $this->familles()->where('titre', $famille)->exists();
    }
    public function hasAnyFamille($familles): bool
    {
        $familles = explode('|', $familles);
        foreach ($familles as $famille) {
            if ($this->familles()->where('titre', $famille)->exists()) {
                return true;
            }
        }
        return false;
    }

}
