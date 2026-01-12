<?php

namespace App\Services\Dashboard;


use App\Models\avis;
use App\Models\Traits\GenericEntityTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AvisService
{
    private AvisService $avisService;
    use GenericEntityTrait;

    public function createUpdateAvis (Request $request, Avis $avis): bool
    {
        $avis = $this->processRequest($request, $avis);
        $avis -> is_actif  = $request -> is_actif!=null;
        $avis -> is_new  = $request -> is_new!=null;
        if($avis->save()) {
            $message = array('type' => 'success', 'message' => 'Le avis a bien été créé!');
            Session::flash('notifications', $message);
        }
        return true;
    }


    public function deleteAvis($id): void
    {
        if ($id != 1) {
            $avis = avis::find($id);
            if (!is_null($avis)) {
                if ($avis->delete()) {
                    $message = array('type' => 'success', 'message' => 'l\'avis client a été définitivement supprimée!');
                    Session::flash('notifications', $message);
                }
            }
        } else {
            $message = array('type' => 'danger', 'message' => 'Vous ne pouvez pas supprimer cet avis!');
            Session::flash('notifications', $message);
        }
    }
}
