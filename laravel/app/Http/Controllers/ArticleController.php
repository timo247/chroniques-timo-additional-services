<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\ArticleRequest;

class ArticleController extends Controller
{
    protected $nbArticlesParPage = 4;
    
    public function __construct() {
        $this->middleware('auth', ['except'=>'index']);
        $this->middleware('admin', ['only'=>'destroy']);
    }
    
    public function index()
    {
        $articles=Article::with('user')
                ->orderBy('articles.created_at','desc')
                ->paginate($this->nbArticlesParPage);
        $links=$articles->render();
        return view('view_articles', compact('articles','links'));
    }
    
    public function create() {
        return view('view_ajoute_article');
    }
    
    public function store(ArticleRequest $request) {
       $inputs=array_merge($request->all(), ['user_id'=>$request->user()->id]);
       Article::create($inputs);
       return redirect(route('articles.index'));
    }
    
    public function destroy($id) {
        Article::findOrFail($id)->delete();  
        return redirect()->back();
    }
}