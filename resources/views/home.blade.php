@extends('layouts.base')

@section('title')マイページ@endsection

@section('content')
@include('flash_msg')
<div class="page-heading u-max-width">
            <h1 class="page-title">マイページ</h1>
        </div>
        <div class="container-multi u-max-width">
            <main class="main">

                <section class="section-item-list">
                    <div class="section-title u-mb-small">
                        <h2>投稿した記事一覧</h2>
                    </div>
                    <section class="section-search u-mb-medium">
                        <div class="form-container form-container--search u-bg-grey">
                            <form action="" class="form form--search">
                                <div class="form__group form__group--half">
                                    <div class="half-form form-select-wrap">
                                        <label for="select" class="form__label">
                                            <span class="label-text">カテゴリ</span>
                                        </label>
                                        <select class="form__select" name="cat_id" id="select">
                                            <option value="" selected>カテゴリーを選択</option>
                                            @foreach ($categoriesList as $category)
                                                <option value="{{ $category->id }}"{{ ($category->id === (int)request('cat_id')) ? ' selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="half-form">
                                        <label for="title" class="form__label">
                                            <span class="label-text">投稿タイトル</span>
                                        </label>
                                        <input type="text" class="form__input" name="title" placeholder="投稿タイトル" id="title" value="{{ request('title') }}">
                                    </div>
                                </div>
                                <div class="form__group">
                                    <span class="form__label">
                                        <span class="label-text">表示順（日付）</span>
                                    </span>
                                    <div class="form-radio-wrap">
                                        <div class="form__radio-group">
                                            <input type="radio" class="form__radio" id="latest" name="sort_date" value="latest"{{ (request('sort_date') === 'latest' || request('sort_date') == '') ? ' checked' : '' }}>
                                            <label for="latest" class="form__label-radio">新しい順</label>
                                        </div>
                                        <div class="form__radio-group">
                                            <input type="radio" class="form__radio" id="oldest" name="sort_date" value="oldest"{{ (request('sort_date') === 'oldest') ? ' checked' : '' }}>
                                            <label for="oldest" class="form__label-radio">古い順</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form__btn">
                                    <button class="btn btn--search" type="submit">検索する</button>
                                </div>
                            </form>
                        </div>
                    </section>
                    @if(!$userPosts->isEmpty())
                        <div class="media u-mb-medium">
                            @foreach ($userPosts as $userPost)
                                <div class="media__item">
                                    <a class="media__link" href="{{ route('posts.show', ['post' => $userPost->id]) }}">
                                        <div class="media__img">
                                            <img src="{{ $userPost->thumbnail_img ? asset(config('post-img.thumbnail_dir') . $userPost->thumbnail_img) : asset(config('post-img.dummy_file_path')) }}" alt="{{ $userPost->title }}">
                                        </div>
                                        <div class="media__body">
                                            <div class="media__heading">
                                                <span class="media-title">{{ str_limit($userPost->title, 60, '...') }}</span>
                                            </div>
                                            <div class="media__description">
                                                <span class="media-date">{{ $userPost->created_at }}</span>
                                                <p>{{ str_limit($userPost->body, 80, '...') }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="u-center-text">
                            {{ $userPosts->appends(request()->only(['cat_id', 'title', 'sort_date']))->onEachSide(1)->links('pagination.default') }}
                        </div>
                    @else
                        <p>記事は見つかりませんでした。</p>
                        <p><a class="link-text" href="{{ route('posts.create') }}">記事を投稿</a>してみましょう。</p>
                    @endif
                </section>
            </main>

            <div class="sidebar">
                <div class="sidebar-content u-bg-grey">
                    <h2 class="sidebar-content__title u-mb-small">Menu</h2>
                    <div class="sidebar-content__body">
                        <p><a class="link-text" href="{{ route('posts.create') }}">記事を投稿する</a></p>
                    </div>
                </div>
            </div>

        </div>
@endsection
