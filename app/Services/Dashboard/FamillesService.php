<?php
namespace App\Services\Dashboard;

use App\Models\Familles;
use App\Models\Traits\GenericEntityTrait;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class FamillesService {
    private FamillesService $famillesService;
    use GenericEntityTrait;
    public function updateImageFamille(Request $request, Familles $famille=null) :bool {
        if($request->hasFile('image')){
            $serviceImage = new ImageService();
            $pathToSave = "img/familles/" . $famille->id ."/images";
            $serviceImage->saveImage($request->file('image'), "/app/public/".$pathToSave,240);
            $famille->image = $pathToSave . '/' . $request->file('image')->getClientOriginalname();
            $famille->save();
        }
        if($request->hasFile('fond')){
            $serviceImage = new ImageService();
            $pathToSave = "img/familles/" . $famille->id . "/fond/";
            $serviceImage->saveImage($request->file('fond'), "/app/public/".$pathToSave, null);
            $famille->fond = $pathToSave . '/' . $request->file('fond')->getClientOriginalname();
            $famille->save();
        }
        return true;
    }
    public function createUpdateFamille (Request $request, Familles $famille): bool
    {
        $famille = $this->processRequest($request, $famille);
        $famille ->slug = Str::slug($request->titre);
        $famille -> is_actif  = $request -> is_actif!=null;
        $famille -> is_new  = $request -> is_new!=null;
        if($famille->save()) {
            $message = array('type' => 'success', 'message' => 'Le famille a bien été créé!');
            Session::flash('notifications', $message);
        }
        $this->updateImageFamille($request,$famille);
        return true;
    }

    public function findFamilles($slug) {
        $famille = Familles::where('slug', $slug)->first();
        if(is_null($famille)) {
            abort(404);
        }
        $projets = $famille->projets->where('is_actif', true);
        if ($projets->isEmpty()) {
            $message = "Nous vous proposerons bientot des informations des projets en cours avec nos clients. Merci de votre compréhension.";
            return view('site.famille', compact('famille', 'message'));
        }
        return view('site.famille', compact('famille','projets'));
    }

    public function deleteFamille($id): void
    {
        if ($id != 1) {
            $famille = Familles::find($id);
            if (!is_null($famille)) {
                if ($famille->delete()) {
                    $message = array('type' => 'success', 'message' => 'la famille a été définitivement supprimée!');
                    Session::flash('notifications', $message);
                }
            }
        } else {
            $message = array('type' => 'danger', 'message' => 'Vous ne pouvez pas supprimer cette famille!');
            Session::flash('notifications', $message);
        }
    }
}
