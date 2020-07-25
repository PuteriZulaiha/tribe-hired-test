<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;
use App\Http\Requests\ValidatePost;
use App\Http\Resources\TopPostResource;

class PostController extends Controller
{
    public function __construct(PostRepository $post)
    {
        $this->post = $post;
    }

    public function getTopPosts(ValidatePost $request)
    {
        $validated = $request->validated();
        $data = $this->post->topPosts($validated);

        return TopPostResource::collection($data);
    }
}