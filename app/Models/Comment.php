<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class Comment extends Model
{
    public function comments()
    {
        $client = new Client(); //GuzzleHttp\Client
        $url = "https://jsonplaceholder.typicode.com/";
        $api_url = $url . 'comments' ;
        $params = [];
         
        $headers = []; //Ususall pass API Tokens or AUTH Credentials
         
        $response = $client->request ('GET', $api_url, [
          //'debug' => config('app.env') !== 'production',
          'json' => $params,
          'headers' => $headers
        ]);
         
        return json_decode( (string)$response->getBody() );
    }

    public function totalCommentPerPost($comments, $limit = 10)
    {
        $totalComments = array_count_values(array_column($comments, 'postId'));
        arsort($totalComments);
        return array_slice($totalComments, 0, $limit, true);
    }

    public function filterComments($comments, $params)
    {
        return collect($comments)->filter(function($comment) use($params){
            $filter = false;
            foreach ($params as $key => $value) {
                if(!isset($comment->$key)) continue;
                
                if($key == 'id' || $key == 'postId')
                  $filter = is_array($value) ? in_array($value, $comment->$key) : $comment->$key == $value;
                else
                  $filter = preg_match("/({$value})+/", $comment->$key);
                
                if(!$filter) break;
            }
            if($filter) return $comment;
        });
    }
}
