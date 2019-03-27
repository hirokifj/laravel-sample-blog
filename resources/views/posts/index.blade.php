@extends('layouts.base')

@section('title')記事一覧@endsection

@section('content')
<div class="container-single">
    <main class="main u-max-width">
        <h1 class="page-title u-mb-medium">記事一覧</h1>
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
        <section class="section-item-list">
            @if(!$posts->isEmpty())
                <div class="card card--3cl">
                    @foreach ($posts as $post)
                        <div class="card__item">
                            <a class="card__link" href="{{ route('posts.show', ['post' => $post->id]) }}">
                                <div class="card__heading">
                                    <h2 class="card-title">{{ str_limit($post->title, 50, '...') }}</h2>
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
                    {{ $posts->appends(request()->only(['cat_id', 'title', 'sort_date']))->onEachSide(1)->links('pagination.default') }}
                </div>
            @else
                <p>検索結果が見つかりませんでした。</p>
                <p>検索条件を変更して、再度お試しください。</p>
            @endif
        </section>
    </main>
</div>
@endsection
