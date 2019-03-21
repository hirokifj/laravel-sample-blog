@extends('layouts.base')

@section('title')ユーザー登録@endsection

@section('content')
<div class="container-single u-bg-grey">
    <main class="main">
        <div class="form-container form-container--small u-bg-white">
            <form method="POST" action="{{ route('register') }}" class="form">
                @csrf
                <div class="form__title">
                    <h1>ユーザー登録</h1>
                </div>

                @include ('errors')
                <div class="form__group">
                    <label for="name" class="form__label">
                        <span class="label-text">ユーザー名</span>
                    </label>
                    <input type="text" class="form__input{{ $errors->has('name') ? ' form__input-error' : '' }}" name="name" placeholder="ユーザー名" id="name" value="{{ old('name') }}">
                </div>
                <div class="form__group">
                    <label for="email" class="form__label">
                        <span class="label-text">メールアドレス</span>
                    </label>
                    <input type="text" class="form__input{{ $errors->has('email') ? ' form__input-error' : '' }}" name="email" placeholder="メールアドレス" id="email" value="{{ old('email') }}" required>
                </div>
                <div class="form__group">
                    <label for="password" class="form__label">
                        <span class="label-text">パスワード</span>
                    </label>
                    <input type="password" class="form__input{{ $errors->has('password') ? ' form__input-error' : '' }}" name="password" placeholder="パスワード" id="password" required>
                </div>
                <div class="form__group">
                    <label for="password-confirm" class="form__label">
                        <span class="label-text">パスワード（再入力）</span>
                    </label>
                    <input type="password" class="form__input" name="password_confirmation" placeholder="パスワード再入力" id="password-confirm" required>
                </div>
                <div class="form__btn u-center-text">
                    <button class="btn btn--primary btn--big" type="submit">登録</button>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection
