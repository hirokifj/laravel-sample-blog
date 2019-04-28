<?php

namespace App\Http\Controllers;

use App\PostTag;
use Illuminate\Http\Request;

class PostTagsController extends Controller
{
    /**
     * タグ毎の記事一覧
     *
     * @param  \App\PostTag  $tag
     * @return \Illuminate\Http\Response
     */
    public function list(PostTag $tag)
    {
        //タグに紐づいた記事を取得
        $posts = $tag->posts()->with('category')->paginate(9);

        return view('tags.list', compact('tag', 'posts'));
    }
}
