<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostCategory;
use App\PostTag;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index']);
    }

    /**
     * 記事一覧を表示
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //記事一覧を取得（GETパラメータに応じて絞り込み）
        $posts = Post::searchCat(request('cat_id'))
            ->searchTitle(request('title'))
            ->sortDate(request('sort_date'))
            ->paginate(9);

        // カテゴリーの一覧を取得する（入力フォームに表示するため）
        $categoriesList = PostCategory::all();

        return view('posts.index', compact('posts', 'categoriesList'));
    }

    /**
     * 記事投稿フォームを表示
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // カテゴリーの一覧を取得する（入力フォームに表示するため）
        $categoriesList = PostCategory::all();
        // タグの一覧を取得する（入力フォームに表示するため）
        $tagsList = PostTag::all();

        return view('posts.create', compact('categoriesList', 'tagsList'));
    }

    /**
     * 新規記事の保存
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //バリデーション
        $attributes = $this->validatePost();
        $tags = $this->validateTags();

        //ユーザーIDを追加
        $attributes['owner_id'] = auth()->id();

        //サムネイル画像のアップロード処理
        if(request()->hasFile('thumbnail_img')) {
            $attributes['thumbnail_img'] = $this->uploadThumbnail();
        } else {
            //画像が送信されていない場合は、空で登録する。
            $attributes['thumbnail_img'] = '';
        }

        //保存処理
        $createdPost = Post::create($attributes);
        $createdPost->tags()->attach($tags['tags']);

        return redirect('/home')->with('status', '投稿が完了しました。');
    }

    /**
     * 投稿の詳細画面を表示
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * 記事の編集フォームを表示
     *
     * @param \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //ユーザーの編集可否権限をチェック
        $this->authorize('edit', $post);

        // カテゴリーの一覧を取得する（入力フォームに表示するため）
        $categoriesList = PostCategory::all();
        // タグの一覧を取得する（入力フォームに表示するため）
        $tagsList = PostTag::all();

        return view('posts.edit', compact('post', 'categoriesList', 'tagsList'));
    }

    /**
     * 記事の更新
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Post $post)
    {
        //ユーザーの編集可否権限をチェック
        $this->authorize('edit', $post);

        //バリデーション処理
        $attributes = $this->validatePost();
        $tags = $this->validateTags();

        //サムネイル画像のアップロード処理
        if(request()->hasFile('thumbnail_img')){
            $attributes['thumbnail_img'] = $this->uploadThumbnail();
        } else {
            //画像が送信されていない場合は、DBの値をそのまま登録する。
            $attributes['thumbnail_img'] = $post->thumbnail_img;
        }

        //保存処理
        $post->update($attributes);
        $post->tags()->sync($tags['tags']);

        return redirect('/home')->with('status', '更新されました。');
    }

    /**
     * 投稿を削除
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //ユーザーの編集可否権限をチェック
        $this->authorize('edit', $post);

        $post->delete();

        return redirect('/home')->with('alert', '投稿を削除しました。');
    }


    /**
     * 投稿記事用のバリデーションメソッド
     *
     * @return array
     */
    protected function validatePost()
    {
        return request()->validate([
            'title' => ['required', 'max:255'],
            'category_id' => ['required', 'exists:post_categories,id'],
            'body' => ['required'],
            'thumbnail_img' => ['file', 'image', 'mimes:jpeg,png', 'max:2048']
        ]);
    }

    /**
     * タグのバリデーションメソッド
     *
     * @return array
     */
    protected function validateTags()
    {
        return request()->validate([
            'tags' => ['array', 'exists:post_tags,id']
        ]);
    }

    /**
     * サムネイル画像のアップロード処理
     *
     * @return string アップロード先のファイル名
     */
    protected function uploadThumbnail()
    {
        //送信された画像をアップロードする
        $FilePath = request()->file('thumbnail_img')->store(config('post-img.thumbnail_upload_dir'));

        //画像のファイル名を取得
        $FileName = basename($FilePath);

        return $FileName;
    }
}
