<?php

namespace App\Http\Controllers;

use App\Models\Familles;
use Illuminate\Http\Request;

class AproposController extends Controller
{
    public function showFamilles() {
        $data['familles']= Familles::where('is_actif',true)->get();
        return view('site.apropos', $data);
    }

}
