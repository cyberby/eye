<?php

namespace App\Http\Controllers;

use App\ReportCondition;
use App\ReportConditionGroup;
use App\Site;
use Illuminate\Http\Request;
use App\Report;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReportController extends Controller
{

    public  function index(Request $request){
        $Report = new Report();
        return [
            'success' => true,
            'message' => "Report listed",
            'data' => $Report->listAll()
        ];
    }

    public function show(Request $request, $id){
        $report = Report::find($id);
        if(!empty($report->query_sql)){
            return DB::select($report->query_sql);
        }
    }

    public function store(Request $request){
        $data = $request->post();
        $Report = new Report();
        $Report->name = $data['name'];
        $Report->query_sql = Report::buildQuery($data);
        if($Report->save()) {
            return ['success' => true,  "message"=> "Report added", "data" => $Report->toArray()];
        }
        return ['success' => false,  "message"=> "Error"];
    }

    public function update(Request $request, $id){
        $data = $request->post();
        $Report = Report::find($id);
        if(!empty($data['name'])){
            $Report->name = $data['name'];
        }
        $Report->query_sql = Report::buildQuery($data);
        if($Report->save()) {
            return ['success' => true,  "message"=> "Report added", "data" => $Report->toArray()];
        }
        return ['success' => false,  "message"=> "Error"];
    }

    public function destroy(Request $request, $id){
        if(Report::destroy($id)){
            return ['success' => true, 'message' => "Report $id deleted"];
        }
        return ['success' => false, 'message' => "Error"];
    }

}
