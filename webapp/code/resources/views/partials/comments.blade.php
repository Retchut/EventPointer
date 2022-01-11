@foreach ($comments as $comment)
    <div class=" m-2 card border-dark">
        <p class= "p-2">
            {{ $comment->messagec }}
        </p>
    </div>

@endforeach
