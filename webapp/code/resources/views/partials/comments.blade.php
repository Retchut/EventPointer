@foreach ($comments as $comment)

    <div class=" m-2 p-2 border border-primary rounded"><span class="text-bold pl-1">
            @php
                echo App\Http\Controllers\EventController::comment_author($comment->id)->username;
            @endphp
            :
        </span>
        <p class="text-bold m-2 p-2" s>{{ $comment->messagec }}</p>
    </div>

@endforeach
