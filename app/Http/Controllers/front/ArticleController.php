<?php

namespace App\Http\Controllers\front;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    //
    public function index(){
        $articles = Article::orderBy('created_at','DESC')
        ->where('status',1)
        ->get();
        return response()->json([
            'status' => true,
            'data' => $articles
        ]);
    }


    public function latestArticles(Request $request){
        $articles = Article::orderBy('created_at','DESC')
        ->where('status',1)
        ->limit($request->limit)
        ->get();

        return response()->json([
            'status' =>true,
            'data' => $articles
        ]);

    }
}
