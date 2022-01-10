@foreach ($comments as $comment)
    <p class="card border-dark mb-3">
        {{ $comment->messagec }}
    </p>
@endforeach
