<?php
namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use GuzzleHttp\Client;

/**
 * Class PostRepository.
 */
class CommentRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        // return Comment::class;
    }

    public function __construct()
    {
        $this->client = new Client();
        $this->api_url = config('app.api_url');
    }

    public function comments()
    {
        $response = $this->client->get($this->api_url.'comments');

        return json_decode ((string) $response->getBody ());
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
