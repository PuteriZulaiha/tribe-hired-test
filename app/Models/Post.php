<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class Post extends Model
{
    public function posts()
    {
        $client = new Client(); //GuzzleHttp\Client
        $url = "https://jsonplaceholder.typicode.com/";
        $api_url = $url . 'posts' ;
        $params = [];
         
        $headers = []; //Ususall pass API Tokens or AUTH Credentials
         
        $response = $client->request ('GET', $api_url, [
          //'debug' => config('app.env') !== 'production',
          'json' => $params,
          'headers' => $headers
        ]);
         
        return json_decode ((string)$response->getBody ());
    }

    public function show($id)
    {
        $client = new Client(); //GuzzleHttp\Client
        $url = "https://jsonplaceholder.typicode.com/";
        $api_url = $url . 'post/'. $id ;
        $params = [];
         
        $headers = []; //Ususall pass API Tokens or AUTH Credentials
         
        $response = $client->request ('GET', $api_url, [
          //'debug' => config('app.env') !== 'production',
          'json' => $params,
          'headers' => $headers
        ]);
         
        return json_decode( (string)$response->getBody() );
    }

    public function topPosts()
    {
        $posts = collect($this->posts())->keyBy('id');

        $comment = new Comment();
        $comments = $comment->comments();
        $comments = $comment->totalCommentPerPost($comments);

        return $posts->whereIn('id',array_keys($comments))->map(function($post) use($comments){
            $post->total_number_of_comments = $comments[$post->id];
            return $post;
        });
    }
}
