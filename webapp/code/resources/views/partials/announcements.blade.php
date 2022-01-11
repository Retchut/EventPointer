@foreach ($announcements as $announcement)
<div class=" m-2 card border-dark">
    <p class= "p-2">
        {{ $announcement->messagea }}
    </p>
</div>
@endforeach
