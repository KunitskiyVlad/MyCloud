<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerLanguages extends Controller
{
    //
    public function GetTranslate(Request $request){
        $translate = $request->input('translate');

        return response()->json(['translate'=>__('interface.'.$translate)]);
    }
}
