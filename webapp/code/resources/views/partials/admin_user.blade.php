<h1>Reports</h1>
<div class="user-events info-div bg-light text-dark rounded">

    @if (count($reports) > 0)
        @foreach ($reports as $report)

            <div class=" m-2 p-2 border border-primary rounded"><span class="text-bold pl-1">
                User '
                    @php
                        echo App\Http\Controllers\UserController::report_author($report->id)->username;
                    @endphp
                    ' made a report in Event
                    @php
                        echo App\Http\Controllers\UserController::report_event($report->id)->eventname;
                    @endphp
                    :
                </span>
                <p class="text-bold m-2 p-2">{{ $report->descriptions }}</p>
            </div>

        @endforeach

    @else
        <h2 class="font-weight-bold pb-2 m-3">No reports found</h2>
    @endif
</div>
