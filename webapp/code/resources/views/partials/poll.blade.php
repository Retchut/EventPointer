@foreach ($polls as $poll)

    <div class=" m-2 p-2 border border-success rounded"><span class="text-bold pl-1">
            @php
                echo App\Http\Controllers\EventController::poll_author($poll->id)->username;
            @endphp
            (Host):
        </span>
        <p class="text-bold m-2 p-2" s>{{ $poll->messagep }}</p>

    </div>

@endforeach