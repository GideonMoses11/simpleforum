<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Topic;
use App\User;
use App\Notifications\NewCommentPosted;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    function __construct(){
        return $this->middleware('auth');
    }

    public function store(Request $request, Topic $topic){
        $request->validate([
            'content' => 'required|min:10'
        ]);

        $comment = new Comment();
        $comment->content = request('content');
        $comment->user_id = auth()->user()->id;

        $topic->comments()->save($comment);

        //notification
        $topic->user->notify(new NewCommentPosted($topic, auth()->user()));

        return  redirect()->route('topics.show', $topic->id);

    }

    public function storeCommentReply(Request $request, Comment $comment){
        $request->validate([
            'replyComment' => 'required|min:3'
        ]);

        $commentReply = new Comment();
        $commentReply->content = request('replyComment');
        $commentReply->user_id = auth()->user()->id;

        $comment->comments()->save($commentReply);

        return  redirect()->back();

    }

    public function markAsSolution()
    {
        $solutionId = Input::get('solutionId');
        $commentId = Input::get('commentId');

        $comment = Topic::find($commentId);
        $comment->solution = $solutionId;
        if ($comment->save()) {
            if (request()->ajax()) {
                return response()->json(['status' => 'success', 'message' => 'marked as solution']);
            }
            return back()->withMessage('Marked as solution');
        }


    }


}
