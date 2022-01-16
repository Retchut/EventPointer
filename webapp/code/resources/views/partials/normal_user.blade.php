<h1 class = "pb-2">Events</h1>
<h3>Participant</h3>
<div class="user-events info-div bg-light text-dark rounded">
    @if (count($events_as_participant) > 0)
        @foreach ($events_as_participant as $event)
            @include('partials.userevent', ['event' => $event])
        @endforeach
    @else
        <h2 class="font-weight-bold pb-2 m-3">This user is not participating in any events</h2>
    @endif
</div>

<h3 class="pt-4">Host</h3>
<div class="user-events info-div bg-light text-dark rounded">
    @if (count($events_as_host) > 0)
        @foreach ($events_as_host as $event)
            @include('partials.userevent', ['event' => $event])
        @endforeach
    @else
        <h2 class="font-weight-bold pb-2 m-3">This user is not hosting in any events</h2>
    @endif
</div>