<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CommentRepository;
use App\Http\Resources\CommentResource;
use App\Http\Requests\ValidateComment;

class CommentController extends Controller
{
    public function __construct(CommentRepository $comment)
    {
        $this->comment = $comment;
    }

    public function index(ValidateComment $request)
    {
        $validated = $request->validated();

        $comments = $this->comment->comments();

        if(!empty($validated))
          $comments = $this->comment->filterComments($comments, $validated);

        return CommentResource::collection($comments);
    }
}