@extends('layouts.base')

@section('title'){{ $tag->name }}の記事一覧@endsection

@section('content')
<div class="container-single">
    <main class="main u-max-width">
        <h1 class="page-title u-mb-medium">#{{ $tag->name }}の記事一覧</h1>
        <section class="section-item-list">
            @if(!$posts->isEmpty())
                <div class="card card--3cl">
                    @foreach ($posts as $post)
                        <div class="card__item">
                            <a class="card__link" href="{{ route('posts.show', ['post' => $post->id]) }}">
                                <div class="card__heading">
                                    <span class="card-title">{{ str_limit($post->title, 50, '...') }}</span>
                                    <div class="card-img">
                                        <img src="{{ $post->thumbnail_img ? asset(config('post-img.thumbnail_dir') . $post->thumbnail_img) : asset(config('post-img.dummy_file_path')) }}" alt="{{ $post->title }}">
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
                    {{ $posts->onEachSide(1)->links('pagination.default') }}
                </div>
            @endif
        </section>
    </main>
</div>
@endsection
