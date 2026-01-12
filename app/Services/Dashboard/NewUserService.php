<?php

namespace App\Services\Dashboard;

use App\Models\User;
use Carbon\Carbon;

class NewUserService
{

    public function getNewUser(): \Illuminate\Database\Eloquent\Collection
    {
        return User::where('is_actif',false)->get();
    }
}
