<?php

namespace App\Http\Controllers;

use App\PostComment;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostCommentsController extends Controller
{
    /**
     * 新規コメントの保存
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function store(Post $post)
    {
        $attributes = request()->validate([
            'body' => ['required', 'min:3', 'max:255']
        ]);

        //ログインユーザーの場合は、ユーザーIDを格納する。
        if(Auth::check()) {
            $attributes['owner_id'] = auth()->id();
        }

        $post->addComment($attributes);

        return back()->with('status', 'コメントしました。');
    }
}
