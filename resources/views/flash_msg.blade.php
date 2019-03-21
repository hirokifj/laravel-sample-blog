@if (session('status'))
    <div class="flash-msg flash-msg--success">
        <p class="flash-msg__message">{{ session('status') }}</p>
    </div>
@elseif (session('alert'))
    <div class="flash-msg flash-msg--alert">
        <p class="flash-msg__message">{{ session('alert') }}</p>
    </div>
@endif
