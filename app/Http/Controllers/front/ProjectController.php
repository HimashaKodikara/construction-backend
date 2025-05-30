<?php

namespace App\Http\Controllers\front;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{

    public function latestProjects(Request $request){
        $projects = Project::orderBy('created_at','DESC')
        ->where('status',1)
        ->limit($request->limit)
        ->get();

        return response()->json([
            'status' =>true,
            'data' => $projects
        ]);
    }

public function index(){
    $projects = Project::orderBy('created_at','DESC')
    ->where('status',1)
    ->get();

    return response()->json([
           'status' => true,
           'data' => $projects
    ]);

}

}
