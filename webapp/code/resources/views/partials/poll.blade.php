@foreach ($polls as $poll)

    <div class=" m-2 p-2 border border-success rounded"><span class="text-bold pl-1">
            @php
                echo App\Http\Controllers\EventController::poll_author($poll->id)->username;
            @endphp
            (Host):
        </span>
        <p class="text-bold m-2 p-2" s>{{ $poll->messagep }}</p>

        @foreach($pollOptions as $pollOption)
            @if($poll->id == $pollOption->pollId)
                <div class="row-sm-auto text-center mb-2"><a class="btn btn-sm btn-outline-success"
                    href="{{ url('/event/' . $event->id) . '/comment' }}">{{ $pollOption->messagepo }} : {{ $pollOption->countvote }}</a></div>
            @endif
        @endforeach

    </div>

@endforeach