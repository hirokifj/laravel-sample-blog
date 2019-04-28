<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PostCategory;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * マイページを表示
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //ログイン中ユーザーの投稿取得
        $userPosts = auth()->user()->posts()
            ->filterCat(request('cat_id'))
            ->filterTitle(request('title'))
            ->sortDate(request('sort_date'))
            ->paginate(5);

        // カテゴリーの一覧を取得する（入力フォームに表示するため）
        $categoriesList = PostCategory::all();

        return view('home', compact('userPosts', 'categoriesList'));
    }
}
