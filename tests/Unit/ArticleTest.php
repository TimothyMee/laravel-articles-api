<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class ArticleTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCreateArticleWithMiddleware()
    {
            $data = [
                    'title' => "New Article",
                    'year' => 2019,
                    'article_type' => "Education Journal",
                    ];

        $response = $this->json('POST', '/api/articles',$data);
        $response->assertStatus(401);
        $response->assertJson(['message' => "Unauthenticated."]);
    }

    public function testCreateArticle()
    {
       $data = [
                'title' => "New Article",
                'year' => 2019,
                'article_type' => "Education Journal",
                ];
        $user = factory(\App\User::class)->create();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/articles',$data);
        $response->assertStatus(201);
        $response->assertJson(['success' => true]);
        $response->assertJson(['data' => $data]);
    }

    public function testGettingAllArticles()
    {
        $user = factory(\App\User::class)->create();
        $article = factory(\App\Article::class)->create(['author' => $user->id]);
        
        $response = $this->json('GET', '/api/articles');
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $response->assertJsonStructure(
            [
                'success',
                'data' => [
                    '*' =>[
                    'id',
                    'title',
                    'year',
                    'article_type',
                    'deleted_at',
                    'created_at',
                    'updated_at',
                    'rating'
                    ]
                ]
            ]
        );
    }

    public function testGettingArticle()
    {
        $user = factory(\App\User::class)->create();
        $article = factory(\App\Article::class)->create(['author' => $user->id]);
        
        $response = $this->json('GET', '/api/articles/'.$article->id);
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $response->assertJsonStructure(
            [
                'success',
                'data' => [
                    '*' =>[
                    'id',
                    'title',
                    'year',
                    'article_type',
                    'deleted_at',
                    'created_at',
                    'updated_at',
                    'rating'
                    ]
                ]
            ]
        );
    }

    public function testGettingMyArticle()
    {
        $user = factory(\App\User::class)->create();
        $article = factory(\App\Article::class)->create(['author' => $user->id]);
        
        $response = $this->actingAs($user, 'api')->json('GET', '/api/my-articles/');
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $response->assertJsonStructure(
            [
                'success',
                'data' => [
                    '*' =>[
                    'id',
                    'title',
                    'year',
                    'article_type',
                    'deleted_at',
                    'created_at',
                    'updated_at',
                    ]
                ]
            ]
        );
    }

    public function testGettingMyArticleFailure()
    {
        $user = factory(\App\User::class)->create();
        $article = factory(\App\Article::class)->create(['author' => $user->id]);
        
        $response = $this->json('GET', '/api/my-articles/');
        $response->assertStatus(401);
        $response->assertJson(['message' => "Unauthenticated."]);
    }

    public function testUpdateArticleFailing()
    {
        $response = $this->json('GET', '/api/articles');
        $response->assertStatus(200);

        $article = $response->getData()->data;
        $article = $article[0];

        $user = factory(\App\User::class)->create();
        // dd($article->id);
        $update = $this->actingAs($user, 'api')->json('PUT', '/api/articles/'.$article->id,['title' => "New Article Title"]);
        $update->assertStatus(401);
        $update->assertJson(['message' => "You cannot edit this article", 'success' => false]);
    } 

    public function testUpdateArticleMiddlewareFailing()
    {
        $response = $this->json('GET', '/api/articles');
        $response->assertStatus(200);

        $article = $response->getData()->data;
        $article = $article[0];

        $update = $this->json('PUT', '/api/articles/'.$article->id, ['title' => "New Article Title"]);
        $update->assertStatus(401);
        $update->assertJson(['message' => "Unauthenticated."]);
    } 

    public function testDeleteArticleFailing()
    {
        $response = $this->json('GET', '/api/articles');
        $response->assertStatus(200);

        $article = $response->getData()->data;
        $article = $article[0];

        $user = factory(\App\User::class)->create();
        $delete = $this->actingAs($user, 'api')->json('DELETE', '/api/articles/'.$article->id);
        $delete->assertStatus(401);
        $delete->assertJson(['message' => "You cannot delete this article", 'success' => false]);
    }

    public function testDeleteArticleMiddlewareFailing()
    {
        $response = $this->json('GET', '/api/articles');
        $response->assertStatus(200);

        $article = $response->getData()->data;
        $article = $article[0];

        $delete = $this->json('DELETE', '/api/articles/'.$article->id);
        $delete->assertStatus(401);
        $delete->assertJson(['message' => "Unauthenticated."]);
    }

    public function testUpdateArticle()
    {

        $user = factory(\App\User::class)->create();
        $article = factory(\App\Article::class)->create(['author' => $user->id]);
        $delete = $this->actingAs($user, 'api')->json('PUT', '/api/articles/'.$article->id);
        $delete->assertStatus(200);
        $delete->assertJson(['message' => "Article has been updated", 'success' => true]);
    }

    public function testDeleteArticle()
    {

        $user = factory(\App\User::class)->create();
        $article = factory(\App\Article::class)->create(['author' => $user->id]);
        $delete = $this->actingAs($user, 'api')->json('DELETE', '/api/articles/'.$article->id);
        $delete->assertStatus(200);
        $delete->assertJson(['message' => "Article Deleted successfully", 'success' => true]);
    }

    public function testRatingArticle()
    {
        $user = factory(\App\User::class)->create();
        $article = factory(\App\Article::class)->create(['author' => $user->id]);
        $data = [
            "rating" => 5
        ];
        $delete = $this->json('POST', '/api/articles/'.$article->id.'/rating', $data);
        $delete->assertStatus(200);
        $delete->assertJson(['message' => "You have rated successfully", 'success' => true]);
    }

    // public function testCreateArticleDate()
    // {

    // }
    

}
