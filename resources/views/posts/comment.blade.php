<section class="section-comment">
    <div class="section-title u-mb-small">
        <h2>この記事へのコメント</h2>
    </div>
    @if($post->comments->count())
        <div class="comment-list u-mb-medium">
            @foreach($post->comments as $comment)
                <div class="comment">
                    <div class="comment__heading">
                        <span class="comment-user">{{ $comment->isOwnerExists() ? $comment->owner->name : '匿名コメント' }}</span>
                        <span class="comment-date">{{ $comment->created_at }}</span>
                    </div>
                    <div class="comment__body">
                        <p>{!! nl2br(e($comment->body)) !!}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <div class="comment-form">
        <form method="POST" action="{{ route('comments.store', ['post' => $post->id]) }}" class="form">
            @csrf
            <div class="form__group">
                <label for="comment" class="form__label">
                    <span class="label-text">新規コメント</span>
                </label>
                <textarea class="form__textarea" name="body" id="comment" rows="7"></textarea>
            </div>
            <div class="form__btn">
                <button class="btn btn--primary" type="submit">コメントする</button>
            </div>
            <div class="form__add-info u-mb-small">
                <p>
                    @guest
                        「匿名ユーザー」としてコメントします。
                    @else
                        「{{ auth()->user()->name }}」としてコメントします。
                    @endguest
                </p>
            </div>
            @include('errors')
        </form>
    </div>
</section>
