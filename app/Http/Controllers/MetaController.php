<?php

namespace App\Http\Controllers;

use App\Meta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MetaController extends Controller
{
    public  function index(Request $request){
        $model_name = $request->query("model_name");
        if(!empty($model_name)){
            return Meta::getFields($model_name);
        }
        return Meta::getModels();
    }

}
