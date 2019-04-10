<div class="card card--3cl">
    @foreach ($posts as $post)
        <div class="card__item">
            <a class="card__link" href="{{ route('posts.show', ['post' => $post->id]) }}">
                <div class="card__heading">
                    <h2 class="card-title">{{ str_limit($post->title, 50, '...') }}</h2>
                    <div class="card-img">
                        <img src="{{ $post->thumbnail_img ? asset(config('post-img.thumbnail_dir') . $post->thumbnail_img) : asset(config('post-img.dummy_file_path')) }}" alt="{{ $post->title }}">
                        <span class="card-category">{{ $post->category->name }}</span>
                    </div>
                </div>
                <div class="card__body">
                    <span class="card-date">{{ $post->created_at }}</span>
                    <p>{{ str_limit($post->body, 60, '...') }}</p>
                </div>
            </a>
        </div>
    @endforeach
</div>
