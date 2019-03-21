@if ($errors->any())
    <div class="form__message form__message--error">
        <ul class="error-list">
            @foreach ($errors->all() as $error)
                <li class="error-list__item">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
