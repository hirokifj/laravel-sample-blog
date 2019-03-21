@extends('layouts.base')

@section('title')パスワード再設定@endsection

@section('content')
<div class="container-single u-bg-grey">
    <main class="main">
        <div class="form-container form-container--small u-bg-white">
            <form method="POST" action="{{ route('password.email') }}" class="form">
                @csrf

                <div class="form__title">
                    <h1>パスワード再設定</h1>
                </div>

                @include ('errors')

                @if (session('status'))
                    <div class="form__message form__message--success">
                        <p>{{ session('status') }}</p>
                    </div>
                @endif

                <div class="form__group">
                    <label for="email" class="form__label">
                        <span class="label-text">登録したメールアドレス</span>
                    </label>
                    <input type="text" class="form__input{{ $errors->has('email') ? ' form__input-error' : '' }}" name="email" placeholder="メールアドレス" id="email" value="{{ old('email') }}" required>
                </div>
                <div class="form__btn u-center-text u-mb-medium">
                    <button class="btn btn--primary btn--big" type="submit">メールを送信</button>
                </div>
                <div class="form__add-info u-center-text">
                    <p>登録メールアドレスに、パスワード再設定メールを送信します。</p>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection
