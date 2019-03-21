@extends('layouts.base')

@section('title')投稿@endsection

@section('content')
<div class="container-single u-bg-grey">
    <main class="main">
        <div class="form-container form-container--medium u-bg-white">
            <form method="POST" action="{{ route('posts.store') }}" class="form" enctype="multipart/form-data">

                @csrf
                <div class="form__title">
                    <h1>投稿</h1>
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
                    <label for="thumbnail_img" class="form__label">
                        <span class="label-text">サムネイル画像</span>
                    </label>
                    <input type="file" name="thumbnail_img">
                </div>
                <div class="form__group">
                    <label for="body" class="form__label">
                        <span class="label-text">本文</span>
                        <span class="form__required-badge">必須</span>
                    </label>
                    <textarea class="form__textarea{{ $errors->has('body') ? ' form__input-error' : '' }}" name="body" id="body" rows="15">{{ old('body')}}</textarea>
                </div>
                <div class="form__btn u-center-text">
                    <button class="btn btn--primary btn--big" type="submit">記事登録</button>
                </div>

            </form>
        </div>
    </main>
</div>
@endsection
