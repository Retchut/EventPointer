@foreach ($announcements as $announcement)
    <div class="m-2 p-2 border border-primary rounded">
        {{ $announcement->messagea }}
    </div>
@endforeach
