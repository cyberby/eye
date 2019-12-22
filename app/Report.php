<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Report extends Model
{
    protected $connection = "mysql";

    public function listAll(){
        return DB::table($this->getTable() )->select(['id', 'name'])->orderBy("name", "asc")->get();
    }
    public static function buildQuery($data){
        $join_model = "App\\".$data['model'];
        $model = new $join_model();
        $table = $model->getTable();
//        $DB = DB::table($data['model']);
        $DB = DB::table($table . ' as ' .$data['model']);
        $where = self::buildWhereRaw($data['conditions']);
        $DB->whereRaw($where);
        $DB = self::buildOrderBy($data['orders'], $DB);
        $DB = self::buildJoins($data['joins'], $DB);
        $query = $DB->toSql();
        return $query;
    }

    private static function buildWhereRaw($condition, $query = "", $connect = ""){
        if(is_array($condition)){
            $array_where = [];
            $count = 0;
            $query = "(";
            $before_is_field = false;
            foreach ($condition as $connector => $item) {
                $conect_condition = $connect;
                if(is_array($item)){
                    if(array_key_exists('column', $item) and array_key_exists('operator', $item) and array_key_exists('value', $item)){
                        $value = $item['value'];
                        if($item['value'] != "NULL"){
                            $value = "'".$item['value']."'";
                        }
//                        $query .= Str::plural($item['model']) . "." . $item['column']." ".$item['operator']." ".$value . " " .$conect_condition. " ";
                        $query .= $item['column']." ".$item['operator']." ".$value . " " .$conect_condition. " ";
                        $array_where[][$count] = [
                            $item['column'],
                            $item['operator'],
                            $item['value']
                        ];
                        $count++;
                        $before_is_field = true;
                    } else {
                        if($connector !== "OR" AND $connector !== "AND"){
                            $connector = "";
                        }
                        if($before_is_field){
                            $conect_condition = "";
                        }
                        $query .= " ". $conect_condition ." ". self::buildWhereRaw($item, $query, $connector);
                        $before_is_field = false;
                    }
                }
            }
            $query .= ")";
            $query = str_replace("( OR ", "(",  $query);
            $query = str_replace("( AND ", "(",  $query);
            $query = str_replace(" OR )", ")",  $query);
            $query = str_replace(" AND )", ")",  $query);
            $query = str_replace(" )", ")",  $query);
            $query = str_replace("( ", "(",  $query);
            $query = trim($query);
            return $query;
        }
    }

    public static function buildOrderBy($orders, $DB){
        foreach ($orders as $key => $order) {
            $DB = $DB->orderBy($key, $order);
        }
        return $DB;
    }

    /**
     * @param $joins
     * @param $DB DB
     */
    public static function buildJoins($joins, $DB){
        foreach ($joins as $join) {
            $join_model = "App\\".$join['model'];
            $model = new $join_model();
            $table = $model->getTable();
            switch ($join['type']){
                case "LEFT":
                    $DB = $DB->leftJoin($table . " as " . $join['model'] ,$join['predicant'], "=", $join['predicate']); break;
                case "RIGHT":
                    $DB =  $DB->rightJoin($table . " as " . $join['model'],$join['predicant'], "=", $join['predicate']); break;
                default:
                    $DB =  $DB->join($table . " as " . $join['model'],$join['predicant'], "=", $join['predicate']); break;
            }
        }
        return $DB;
    }
//    public function reportJoins()
//    {
//        return $this->hasMany('App\ReportJoin','report_id');
//    }
//
//    public function reportConditions()
//    {
//        return $this->hasMany('App\ReportCondition','report_id');
//    }
//
//    public function reportOrders()
//    {
//        return $this->hasMany('App\ReportOrder','report_id');
//    }
}
