@extends('layouts.base')

@section('title'){{ $tag->name }}の記事一覧@endsection

@section('content')
<div class="container-single">
    <main class="main u-max-width">
        <h1 class="page-title u-mb-medium">#{{ $tag->name }}の記事一覧</h1>
        <section class="section-item-list">
            @if(!$posts->isEmpty())

                @include('posts.posts_list')

                <div class="u-center-text">
                    {{ $posts->onEachSide(1)->links('pagination.default') }}
                </div>
            @endif
        </section>
    </main>
</div>
@endsection
