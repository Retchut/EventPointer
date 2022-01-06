<h1>Events</h1>
<div class="user-events info-div bg-light text-dark rounded">
    @if (count($events) > 0)
        @foreach ($events as $event)
            @include('partials.userevent', ['event' => $event])
        @endforeach
    @else
        <h2 class="font-weight-bold pb-2 m-3">This user is not participating in any events</h2>
    @endif
</div>