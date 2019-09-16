<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Rating;

class RatingController extends Controller
{
    public function rate(Request $request, $id)
    {
        try{
            $article = Article::find($id);
            if (!$article) {
                return response()->json([
                    'success' => false,
                    'message' => 'Article with id ' . $id . ' not found'
                ], 404);
            } 

            $this->validate($request, [
                'rating' => 'required|integer',
            ]);

            //check if rating is within rules
            if($request->rating <= 0 || $request->rating > 5)
                return response()->json([
                    'success' => false,
                    'message' => 'Rating starts from 1 and must not be greater than 5'
                ], 400);
                
            //check if user has rated before. ----no need for this anymore, since the route is unprotected----
            // $ratingCheck = Rating::where(['article_id' => $id, 'rater_id' => auth() ])

            $rating = new Rating();     
            //get ratings for article
            $articleRating = $rating->where(['article_id' => $id])->get();
            if(!empty($articleRating->toArray())){
                $articleRating = $articleRating[0];
                $articleRating->total_ratings = $articleRating->total_ratings + $request->rating;
                $articleRating->no_of_raters = $articleRating->no_of_raters + 1;
                $articleRating->average_rating = $articleRating->total_ratings / $articleRating->no_of_raters;

                $articleRating->save();
                return response()->json([
                    'success' => true,
                    'message' => 'You have rated successfully'
                ], 200);
            }else{
                $rating = $rating->create([
                    'article_id' => $id,
                    'no_of_raters' => 1,
                    'total_ratings' => $request->rating,
                    'average_rating' => $request->rating
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'You have rated successfully'
                ], 200);
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
