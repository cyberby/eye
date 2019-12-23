<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Meta extends Model
{
    protected $table = 'metas';
    protected $connection = 'mysql';

    public static function getModels(){
        return DB::table("metas")->select("model")->distinct("model")->get();
    }

    public static function getFields($model_name){
        return DB::table("metas")->select("*")->where("model", '=', $model_name)->get();
    }

    public function listTableForeignKeys($table)
    {
        $conn = Schema::getConnection()->getDoctrineSchemaManager();

        return array_map(function($key) {
            return $key->getName();
        }, $conn->listTableForeignKeys($table));
    }
}
