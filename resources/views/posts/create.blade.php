@extends('layouts.base')

@section('title')記事投稿@endsection

@section('content')
<div class="container-single u-bg-grey">
    <main class="main">
        <div class="form-container form-container--medium u-bg-white">
            <form method="POST" action="{{ route('posts.store') }}" class="form" enctype="multipart/form-data">

                @csrf
                <div class="form__title">
                    <h1>新規投稿</h1>
                </div>

                @include('errors')

                <div class="form__group">
                    <label for="title" class="form__label">
                        <span class="label-text">記事タイトル</span>
                        <span class="form__required-badge">必須</span>
                    </label>
                    <input type="text" class="form__input{{ $errors->has('title') ? ' form__input-error' : '' }}" name="title" placeholder="記事タイトル" id="title" value="{{ old('title')}}">
                </div>
                <div class="form__group form__group--half">
                    <div class="half-form form-select-wrap">
                        <label for="category_id" class="form__label">
                            <span class="label-text">カテゴリー</span>
                            <span class="form__required-badge">必須</span>
                        </label>
                        <select class="form__select{{ $errors->has('category_id') ? ' form__input-error' : '' }}" name="category_id" id="category_id">
                            <option value="" selected>カテゴリーを選択</option>
                            @foreach ($categoriesList as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form__group">

                    <live-preview-input key-name="thumbnail_img"></live-preview-input>

                </div>
                <div class="form__group">
                    <label for="body" class="form__label">
                        <span class="label-text">本文</span>
                        <span class="form__required-badge">必須</span>
                    </label>
                    <textarea class="form__textarea{{ $errors->has('body') ? ' form__input-error' : '' }}" name="body" id="body" rows="15">{{ old('body')}}</textarea>
                </div>
                <div class="form__group">
                    <span class="form__label">
                        <span class="label-text">関連タグ</span>
                    </span>
                    <div class="form-check-wrap">
                        @foreach($tagsList as $tag)
                            <div class="form__check-group">
                                <input class="field form__checkbox" id="tag-{{ $tag->id }}" name="tags[]" type="checkbox" value="{{ $tag->id }}">
                                <label class="form__label-checkbox" for="tag-{{ $tag->id }}">{{ $tag->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="form__btn u-center-text">
                    <button class="btn btn--primary btn--big" type="submit">記事登録</button>
                </div>

            </form>
        </div>
    </main>
</div>
@endsection
