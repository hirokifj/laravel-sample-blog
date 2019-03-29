<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostCategory;
use App\PostTag;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;

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
        // 記事一覧を取得（GETパラメータに応じて絞り込み）
        $posts = Post::with('category')
            ->searchCat(request('cat_id'))
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
     * @param  App\Http\Requests\PostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        // 記事に関するリクエスト値のみを格納
        $attributes = $request->except('tags');
        // ユーザーIDを追加
        $attributes['owner_id'] = auth()->id();

        // サムネイル画像のアップロード処理
        $this->uploadThumbnailIfNeeded($request, $attributes);

        // 保存処理
        Post::create($attributes)
            ->tags()->attach($request->tags);

        return redirect('/home')->with('status', '投稿が完了しました。');
    }

    /**
     * 記事の詳細画面を表示
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
        // ユーザーの編集可否権限をチェック
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
     * @param  App\Http\Requests\PostRequest  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        // ユーザーの編集可否権限をチェック
        $this->authorize('edit', $post);

        // 記事に関するリクエスト値のみを格納
        $attributes = $request->except('tags');

        // サムネイル画像のアップロード処理
        $this->uploadThumbnailIfNeeded($request, $attributes);

        // 保存処理
        $post->update($attributes);
        $post->tags()->sync($request->tags);

        return redirect('/home')->with('status', '更新されました。');
    }

    /**
     * 記事を削除
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // ユーザーの編集可否権限をチェック
        $this->authorize('edit', $post);

        $post->delete();

        return redirect('/home')->with('alert', '投稿を削除しました。');
    }

    /**
     * サムネイル画像のアップロード処理
     *
     * サムネイル画像のファイルが送信されていれば、アップロード処理を行い、
     * $attributesに、アップロード後のファイル名を格納する。
     * 送信されていない場合は、何もしない。
     *
     * @param array  $request
     * @param array  $attributes postsテーブルに保存するデータ（値渡し）
     * @return void
     */
    protected function uploadThumbnailIfNeeded($request, &$attributes)
    {
        $thumbnailKeyName = 'thumbnail_img';

        if(!$request->hasFile($thumbnailKeyName)) {
            return;
        }

        // 送信された画像をアップロードする
        $FilePath = $request->file($thumbnailKeyName)->store(config('post-img.thumbnail_upload_dir'));

        // 画像のファイル名を格納
        $attributes[$thumbnailKeyName] = basename($FilePath);
    }
}
