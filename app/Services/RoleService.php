<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function createUpdateRole(Request $request){
        $role = Role::find($request->role_id) ?? new Role();
        $role->name           = $request->name;
        $role->name_function  = $request->name_fct;
        if($role->save()){
            $message = array('type' => 'success', 'message' => 'Le nouveau rôle a bien été créé!');
            Session::flash('notifications', $message);
        }
        $role->syncPermissions($request->permissions);
    }
    public function deleteRole($id): void
    {
        $role = Role::find($id);
        if(!is_null($role)) {
            if ($role->delete()) {
                $message = array('type' => 'success', 'message' => 'le membre a été definitivement supprimé!');
                Session::flash('notifications', $message);
            }
        }
    }


}
