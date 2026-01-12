<?php

namespace App\Models\Traits;

use Illuminate\Http\Request;

trait GenericEntityTrait
{
    private function processRequest(Request $request, $model) {

        $allRequestKeys = $request->keys();
        foreach ($allRequestKeys as $requestKey) {
            if(in_array($requestKey, $model->getFillable())) {
                $model->$requestKey = $request->get($requestKey);
            }
        }
        return $model;
    }
}
