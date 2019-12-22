<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Meta extends Model
{
    protected $table = 'metas';
    protected $connection = 'mysql';
    public function predicates()
    {
        return $this->hasMany('App\ReportJoin','predicate');
    }

    public function predicants()
    {
        return $this->hasMany('App\ReportJoin','predicant');
    }

    public function reportConditions()
    {
        return $this->hasMany('App\ReportCondition','meta_id');
    }

    public function reportOrders()
    {
        return $this->hasMany('App\ReportOrder','meta_id');
    }

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
