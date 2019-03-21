@extends('layouts.base')

@section('title')ログイン@endsection

@section('content')
<div class="container-single u-bg-grey">
    <main class="main">
        <div class="form-container form-container--small u-bg-white">
            <form method="POST" action="{{ route('login') }}" class="form">
                @csrf

                <div class="form__title">
                    <h1>ログイン</h1>
                </div>

                @include ('errors')

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
                    <input type="password" class="form__input" name="password" placeholder="パスワード" id="password" required>
                </div>
                <div class="form__group">
                    <div class="form-check-wrap">
                        <div class="form__check-group">
                            <input class="field form__checkbox" id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form__label-checkbox" for="remember">ログインしたままにする</label>
                        </div>
                    </div>
                </div>
                <div class="form__btn u-center-text u-mb-medium">
                    <button class="btn btn--primary btn--big" type="submit">ログイン</button>
                </div>
                @if (Route::has('password.request'))
                    <div class="form__add-info">
                        <a class="link-text" href="{{ route('password.request') }}">パスワードをお忘れの方はこちら</a>
                    </div>
                @endif
            </form>
        </div>
    </main>
</div>
@endsection
