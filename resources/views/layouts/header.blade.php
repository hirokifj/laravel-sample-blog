<header class="header">
    <div class="header-container">
        <div class="header-logo">
            <h1 class="header-logo__text"><a class="header-logo__link" href="{{ url('/') }}">{{ config('app.name', 'Sample Media') }}</a></h1>
        </div>
        <nav class="main-nav">
            <ul class="main-nav__list">
                @guest
                    <li class="main-nav__item"><a class="main-nav__link" href="{{ route('login') }}">ログイン</a></li>
                    <li class="main-nav__item"><a class="main-nav__link" href="{{ route('register') }}">会員登録</a></li>
                @else
                    <li class="main-nav__item"><a class="main-nav__link" href="{{ route('home') }}">マイページ</a></li>
                    <li class="main-nav__item">
                        <a class="main-nav__link" href="#"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                            ログアウト
                        </a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endguest
            </ul>
        </nav>
    </div>
</header>
