<?php
namespace App\Services\Dashboard;

use App\Models\Familles;
use App\Models\projets;
use App\Models\Traits\GenericEntityTrait;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ProjetsService {
    use GenericEntityTrait;

    private ProjetsService $projetsService;

    public function updateImageProjet(Request $request, Projets $projet=null) :bool {
        if($request->hasFile('image')){
            $serviceImage = new ImageService();
            $pathToSave = "img/projets/" . $projet->id ."/images";
            $serviceImage->saveImage($request->file('image'), "/app/public/".$pathToSave,240);
            $projet->image = $pathToSave . '/' . $request->file('image')->getClientOriginalname();
            $projet->save();
        }

        return true;
    }
    public function createUpdateProjet (Request $request, Projets $projet ): bool
    {
        $projet = $this->processRequest($request, $projet);
        $projet -> slug        = Str::slug($request->titre);
        $projet -> is_actif    = $request -> is_actif!=null;
        $projet -> is_new      = $request -> is_new!=null;
//        $projet -> familles_id = $request -> familles_id !=null;

        if($projet->save()) {
            $message = array('type' => 'success', 'message' => 'Le projet a bien été créé!');
            Session::flash('notifications', $message);
        }
        $this->updateImageprojet($request,$projet);
        return true;
    }

    public function findprojets($slug) {
        $projet = projets::where('slug', $slug)->first();
        if(is_null($projet)) {
            abort(404);
        }
        $projets = $projet->projets->where('is_actif', true);
        if ($projets->isEmpty()) {
            $message = "Nous vous proposerons bientot des informations des projets en cours avec nos clients. Merci de votre compréhension.";
            return view('site/projet', compact('projet', 'message'));
        }
        return view('site/projet', compact('projet','projets'));
    }

    public function deleteprojet($id): void
    {
        if ($id != 1) {
            $projet = projets::find($id);
            if (!is_null($projet)) {
                if ($projet->delete()) {
                    $message = array('type' => 'success', 'message' => 'la projet de produit a été définitivement supprimée!');
                    Session::flash('notifications', $message);
                }
            }
        } else {
            $message = array('type' => 'danger', 'message' => 'Vous ne pouvez pas supprimer cette projet!');
            Session::flash('notifications', $message);
        }
    }
}
