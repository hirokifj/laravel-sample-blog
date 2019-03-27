@extends('layouts.base')

@section('title')
TOP
@endsection

@section('content')
@include('flash_msg')
<div class="hero-box">
    <div class="hero-box__text u-center-text">
        <h1 class="hero-copy u-mb-small">ブログサービスのサンプル</h1>
        <div class="hero-box__btn">
            <a class="btn btn--primary" href="{{ route('register') }}">ユーザー登録する</a>
            <a class="btn btn--ghost" href="{{ route('posts.index') }}">記事を探す</a>
        </div>
    </div>
</div>
<div class="container-single u-max-width">
    <main class="main">
        <section class="section-item-list u-mb-big">
            <div class="section-title u-mb-medium">
                <h2>ユーザーの新着記事</h2>
            </div>
            <div class="card card--3cl">
                @foreach ($posts as $post)
                    <div class="card__item">
                        <a class="card__link" href="{{ route('posts.show', ['post' => $post->id]) }}">
                            <div class="card__heading">
                                <span class="card-title">{{ str_limit($post->title, 50, '...') }}</span>
                                <div class="card-img">
                                    <img src="{{ $post->thumbnail_img ? asset(config('post-img.thumbnail_dir') . $post->thumbnail_img) : asset(config('post-img.dummy_file_path')) }}" alt="{{ $post->title }}">
                                    <span class="card-category">{{ $post->category->name }}</span>
                                </div>
                            </div>
                            <div class="card__body">
                                <span class="card-date">{{ $post->created_at }}</span>
                                <p>{{ str_limit($post->body, 60, '...') }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="u-center-text">
                <a class="btn btn--primary btn--small" href="{{ route('posts.index') }}">ユーザーの記事を探す</a>
            </div>
        </section>
        <section class="section-tag-list">
            <div class="section-title u-mb-small">
                <h2>タグ</h2>
            </div>
            <ul class="tag-list">
                @foreach($tags as $tag)
                    <li class="tag-list__item"><a href="{{ route('tags.list', ['tag' => $tag->id]) }}" class="tag-list__link">#{{ $tag->name }}</a></li>
                @endforeach
            </ul>
        </section>
    </main>
</div>
@endsection
