<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use App\Models\Traits\GenericEntityTrait;
class UserService
{
    use GenericEntityTrait;


    public function updateUserAvatar(Request $request,User $user=null) :bool {
        if($request->hasFile('avatar')){
            $serviceImage = new ImageService();
            $user = $user!=null ? $user : Auth::user();
            $pathToSave = "img/user/" . $user->id;
            $serviceImage->saveImage($request->file('avatar'), "/app/public/".$pathToSave, 200);
            $user->avatar = $pathToSave . '/' . $request->file('avatar')->getClientOriginalname();
            return  $user->save();
        }
        return false;
    }
    public function updateUser(Request $request): void
    {
        $user = User::find($request->userid);
        $user = $this->processRequest($request, $user);
        $user -> is_actif  = $request -> is_actif!=null;
        if($user->save()) {
            $message = array('type' => 'success', 'message' => 'cet utilisateur a bien été modifié!');
            Session::flash('notifications', $message);
        }
        $this->updateUserAvatar($request,$user);
        $user->syncRoles($request->role_user);
    }
    public function toggleStatusUser($id)
    {
        if ($id!=1) {
            $user = User::find($id);
            if(!is_null($user)) {
                $user->is_actif = !$user->is_actif;
                $user->save();
                $message =  $user->is_actif
                    ? array('type' => 'success', 'message' => 'Votre membre est bien activé!')
                    : array('type' => 'success', 'message' => 'Votre membre a bien été désactivé!');
                Session::flash('notifications', $message);
            }
        }else{
            $message = array('type' => 'danger', 'message' => 'Vous ne pouvez pas désactivé ce compte!');
            Session::flash('notifications', $message);
        }
    }
    public function deleteUser($id)
    {
        if ($id!=1) {
            $user = User::find($id);
            if(!is_null($user)) {
                if ($user->delete()) {
                    $message = array('type' => 'success', 'message' => 'le membre a été definitivement supprimé!');
                    Session::flash('notifications', $message);
                }
            }
        }else{
            $message = array('type' => 'danger', 'message' => 'Vous ne pouvez pas supprimer ce compte!');
            Session::flash('notifications', $message);
        }
    }
}
