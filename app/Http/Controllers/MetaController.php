<?php

namespace App\Http\Controllers;

use App\Meta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MetaController extends Controller
{
    public  function index(Request $request){
        $model_name = $request->query("model_name");
        $data = [];
        if(!empty($model_name)){
            $data = Meta::getFields($model_name);
        } else {
            $data = Meta::getModels();
        }

        return json_encode([
            'success'=> true,
            'message'=> 'success',
            'data' => $data
        ]);
    }

}
