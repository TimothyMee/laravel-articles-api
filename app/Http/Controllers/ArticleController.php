<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = auth()->user()->articles;
 
        return response()->json([
            'success' => true,
            'data' => $articles
        ]);
    }
 
    public function show($id, Article $articles)
    {
       try{
        $article = $articles->where('id', $id)->with('rating')->get();
 
        if (empty($article->toArray())) {
            return response()->json([
                'success' => false,
                'message' => 'article with id ' . $id . ' not found'
            ], 404);
        }
 
        return response()->json([
            'success' => true,
            'data' => $article->toArray()
        ], 200);
       }
       catch(\Exception $e)
       {
        return response()->json([
            'success' => false,
            'data' => $e->getMessage()
        ], 500);
       }
    }

    public function getAll(Article $article)
    {
        try{
            $articles = $article->with('rating')->get();

            if (empty($article->toArray())) {
                return response()->json([
                    'success' => false,
                    'message' => 'no article found'
                ], 404);
            }
     
            return response()->json([
                'success' => true,
                'data' => $articles->toArray()
            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
 
    public function store(Request $request, Article $article)
    {
        try{
            $this->validate($request, [
                'title' => 'required|min:6',
                'year' => 'required|integer',
                'article_type' => 'required'
            ]);
     
            $article->title = $request->title;
            $article->year = $request->year;
            $article->article_type = $request->article_type;
            $article->author = auth()->user()->id;
     
            if (auth()->user()->articles()->save($article))
                return response()->json([
                    'success' => true,
                    'data' => $article->toArray()
                ], 201);
            else
                return response()->json([
                    'success' => false,
                    'message' => 'Article could not be added'
                ], 500);
        }
        catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }            
    }
 
    public function update(Request $request, $id)
    {
        try{
            $article = auth()->user()->articles()->find($id);
 
            if (!$article) {
                return response()->json([
                    'success' => false,
                    'message' => 'Article with id ' . $id . ' not found'
                ], 400);
            }
    
            $updated = $article->fill($request->all())->save();
    
            if ($updated)
                return response()->json([
                    'success' => true,
                    'message' => 'Article has been updated'
                ], 200);
            else
                return response()->json([
                    'success' => false,
                    'message' => 'Article could not be updated'
                ], 500);
        }
        catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
 
    public function destroy($id)
    {
        try{
            $article = auth()->user()->articles()->find($id);
 
            if (!$article) {
                return response()->json([
                    'success' => false,
                    'message' => 'Article with id ' . $id . ' not found'
                ], 400);
            }
    
            if ($article->delete()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Article Deleted successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Article could not be deleted'
                ], 500);
            }
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
