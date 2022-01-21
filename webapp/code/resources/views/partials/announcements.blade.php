@foreach ($announcements as $announcement)

    <div class=" m-2 p-2 border border-primary rounded"><span class="text-bold pl-1">
            @php
                echo App\Http\Controllers\EventController::announcement_author($announcement->id)->username;
            @endphp
            :
        </span>
        <p class="text-bold m-2 p-2" s>{{ $announcement->messagea }}</p>
    </div>

@endforeach
