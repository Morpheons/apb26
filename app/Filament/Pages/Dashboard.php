<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    // C'est ici qu'on définit les 12 colonnes pour la grille
    public function getColumns(): int| array
    {
        return 12;
    }
}
