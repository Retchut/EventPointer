@foreach ($comments as $comment)
    <div class=" m-2 p-2 border border-primary rounded">
        {{ $comment->messagec }}
    </div>
@endforeach
