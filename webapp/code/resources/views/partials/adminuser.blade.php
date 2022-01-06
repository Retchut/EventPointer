<h1>Reports</h1>
<div class="user-events info-div bg-light text-dark rounded">

    @if (count($reports) > 0)
        @foreach ($reports as $report)
            <div class="row user-event m-3 p-2 info-div rounded">

                <h4> Description: {{ $report->descriptions }}</h4>
                <h5> Reported by user with id={{$report->userid}}</h5>
                <h5> Report on event with id={{$report->eventid}} </h5>
            </div>

        @endforeach
    @else
        <h2 class="font-weight-bold pb-2 m-3">No reports found</h2>
    @endif
</div>
