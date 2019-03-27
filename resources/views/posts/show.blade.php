@extends('layouts.base')

@section('title'){{ $post->title }}@endsection

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
                <span class="category-badge">{{ $post->category->name }}</span>
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
        <section class="section-description u-mb-big">
            <p>{!! nl2br(e($post->body)) !!}</p>
        </section>
        @if($post->tags->count())
            <section class="section-tag">
                <div class="section-title u-mb-small">
                    <h2>タグ</h2>
                </div>
                <ul class="tag-list">
                    @foreach($post->tags as $tag)
                        <li class="tag-list__item"><a href="{{ route('tags.list', ['tag' => $tag->id]) }}" class="tag-list__link">#{{ $tag->name }}</a></li>
                    @endforeach
                </ul>
            </section>
        @endif
    </article>
    @include('posts.comment')
</div>
@endsection
