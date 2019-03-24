@extends('layouts.base')

@section('title')詳細@endsection

@section('content')
@include('flash_msg')
<div class="container-single u-max-width">
    <article class="article u-mb-big">
        <h1 class="article-title u-mb-small">{{ $post->title }}</h1>
        @if ($post->thumbnail_img)
            <section class="section-img-box u-mb-small">
                <img src="{{ asset('storage/thumbnails/' . $post->thumbnail_img) }}" alt="{{ $post->title }}" class="main-img">
            </section>
        @endif
        <section class="section-info u-mb-medium">
            <div class="post-info u-mb-small">
                <a class="category-badge" href="#">{{ $post->category->name }}</a>
                @can('edit', $post)
                    <div class="edit-link">
                        <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="link-text">編集する</a>
                        <a class="link-text" href="#"
                            onclick="event.preventDefault();
                                     document.getElementById('delete-form').submit();">
                            削除する
                        </a>
                        <form id="delete-form" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                @endcan
            </div>
            <div class="author-info">
                <span>投稿ユーザー：</span>
                <span class="author-name">{{ $post->owner->name }}</span>
            </div>

        </section>
        <section class="section-description">
            <p>{!! nl2br(e($post->body)) !!}</p>
        </section>
    </article>
    @include('posts.comment')
</div>
@endsection
