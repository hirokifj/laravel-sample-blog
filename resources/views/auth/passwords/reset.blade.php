@extends('layouts.base')

@section('title')パスワード再設定@endsection

@section('content')
<div class="container-single u-bg-grey">
    <main class="main">
        <div class="form-container form-container--small u-bg-white">
            <form method="POST" action="{{ route('password.update') }}" class="form">
                @csrf

                <div class="form__title">
                    <h1>パスワード再設定</h1>
                </div>

                @include ('errors')

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form__group">
                    <label for="email" class="form__label">
                        <span class="label-text">登録メールアドレス</span>
                    </label>
                    <input type="text" class="form__input{{ $errors->has('email') ? ' form__input-error' : '' }}" name="email" placeholder="メールアドレス" id="email" value="{{ old('email') }}" required>
                </div>
                <div class="form__group">
                    <label for="password" class="form__label">
                        <span class="label-text">新パスワード</span>
                    </label>
                    <input type="password" class="form__input" name="password" placeholder="新パスワード" id="password" required>
                </div>
                <div class="form__group">
                    <label for="password-confirm" class="form__label">
                        <span class="label-text">新パスワード（再入力）</span>
                    </label>
                    <input type="password" class="form__input" name="password_confirmation" placeholder="新パスワード再入力" id="password-confirm" required>
                </div>
                <div class="form__btn u-center-text u-mb-medium">
                    <button class="btn btn--primary btn--big" type="submit">パスワード再設定</button>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection
