<?php

namespace App\Http\Controllers;

use App\Models\Familles;
use App\Models\Projets;
use App\Services\Dashboard\ProjetsService;
use Illuminate\Http\Request;

class ProjetController extends Controller
{
    private ProjetsService $projetsService;

    public function __construct(ProjetsService $projetsService) {
        $this->projetsService = $projetsService;

    }

    public function list(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
//        $data['projets']= Projets::paginate(50);
        $data['projets'] = Projets::with('famille')->paginate(10);
        return view('admin.projet.liste', $data);
    }
    public function showProjet($slug) {
        $data['projet'] = Projets::where('slug', $slug)->where('is_actif', true)->first();
        if(is_null($data['projet'])) {
            abort(404);
        }
        $data['famille'] = $data['projet']->famille;
        $data['familles'] = Familles::all();
        return view('site.detail', $data);
    }
    public function new() {
        $data['projet'] = new Projets();
        $data['familles'] = Familles::all();
        return view('admin.projet.projet_new',$data);
    }
    public function create(Request $request)
    {
        $projet = new Projets();
        $this->projetsService->createUpdateProjet($request, $projet);
        return redirect()->route('list_projet');
    }

    public function edit($id){
        $data['projet'] = Projets::find($id);
        $data['familles'] = Familles::all();
        return view('admin.projet.projet_edit', $data);
    }

    public function update(Request $request, Projets $projet){
         $this->projetsService -> createUpdateProjet($request, $projet);
        return redirect()->route('list_projet');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete_projet($id)
    {
        $this->projetsService->deleteprojet($id);
        return redirect()->route('list_projet');
    }
}
