<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateComment;
use App\Models\Comment;

class CommentController extends Controller
{
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function index(ValidateComment $request)
    {
        $validated = $request->validated();

        $comments = $this->comment->comments();

        if(!empty($validated))
          $comments = $this->comment->filterComments($comments, $validated);

        return $comments;
    }
}