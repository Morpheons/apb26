<?php

namespace App\Services;

use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Traits\GenericEntityTrait;
use Illuminate\Support\Facades\Session;

class ServiceService {
    use GenericEntityTrait;

    public function createUpdateService(Request $request): void
    {
        $service = Service::find($request->service_id) ?? new Service();
        $service->nom        = $request->nom;
        $service->descriptif = $request->descriptif;
        $service->is_actif   = $request->is_actif != null;
        if($service->save()){
            $message = array('type' => 'success', 'message' => 'Le service a bien été créé ou modifié!');
            Session::flash('notifications', $message);
        }
    }
    public function deleteService($id): void
    {
        $service = Service::find($id);
        if(!is_null($service )) {
            if ($service ->delete()) {
                $message = array('type' => 'success', 'message' => 'le service a été definitivement supprimé!');
                Session::flash('notifications', $message);
            }
        }
    }
}
