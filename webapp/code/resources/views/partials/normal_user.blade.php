<h1>Events</h1>
<div class="border border-primary rounded bg-light text-dark">
    @if (count($events) > 0)
        @foreach ($events as $event)
            @include('partials.userevent', ['event' => $event])
        @endforeach
    @else
        <p class="font-weight-bold pb-2 m-3">This user is not participating in any events</p>
    @endif
</div>
