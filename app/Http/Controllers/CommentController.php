<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = new Comment($request->all());
        $comment->task_id = $task->id;
        $comment->user_id = Auth::id();
        $comment->save();

        return back()->with('success', 'Comment has been added succesfully!');
    }
}
