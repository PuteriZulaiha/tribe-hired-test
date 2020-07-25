<?php
namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use GuzzleHttp\Client;

/**
 * Class PostRepository.
 */
class PostRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        // return Post::class;
    }

    public function __construct()
    {
        $this->client = new Client();
        $this->api_url = config('app.api_url');
    }

    public function posts()
    {
        $response = $this->client->get($this->api_url.'posts');

        return json_decode ((string) $response->getBody ());
    }

    public function topPosts($request, $limit = 10)
    {
        $limit = isset($request['limit']) ? $request['limit'] : $limit;

        $comment = new CommentRepository();
        $comments = $comment->comments();

        $posts = collect($this->posts())->keyBy('id');
        $posts = $posts->map(function($post)use($comment,$comments){
            $comments = $comment->filterComments($comments, ['postId'=>$post->id]);
            $post->total_number_of_comments = $comments->count();

            return $post;
        });

        return $posts->sortByDesc('total_number_of_comments')->take($limit);
    }
}
