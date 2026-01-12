<?php

namespace App\Http\Controllers;

use App\Models\avis;
use App\Models\Familles;
use Illuminate\Http\Request;

class AccueilController extends Controller
{
    public function accueil(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $data['familles']= Familles::where('is_actif',true)->get();
        $data['avis']= Avis::where('is_actif',true)->get();
        return view('site.accueil', $data);
    }
    public function showFamilles($slug): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $data['familles']= Familles::where('is_actif',true)->get();
        $data['avis']= Avis::where('is_actif',true)->get();
        $data['famille'] = Familles::where('slug', $slug)->firstOrFail();
        $data['projets'] = $data['famille']->projets()->actifs()->get();
        if ($data['projets']->isEmpty()) {
            $data['message'] = "Nous vous proposerons bientot des informations des projets en cours avec nos clients. Merci de votre compréhension.";
        }
        return view('site.famille', $data);
    }
}
