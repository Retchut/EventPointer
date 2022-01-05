@extends('layouts.app')

@section('title', 'Event')

@section('content')

<section id="event">
    <div class="container-fluid p-4">
        <div class="event-details pb-5">
            <div class="row">
                <div class="col-sm-8 event-info">
                    <h1 class="font-weight-bold pb-2">{{$event->eventname}}</h1>
                    <div class="row pb-1">
                        <div class="col-1 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-event text-center"  viewBox="0 0 16 16">
                                <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" />
                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                            </svg>
                        </div>
                        <div class="col">
                            <h5> {{$event->startdate}} - {{$event->enddate}}</h5>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col-1 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-map" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15.817.113A.5.5 0 0 1 16 .5v14a.5.5 0 0 1-.402.49l-5 1a.502.502 0 0 1-.196 0L5.5 15.01l-4.902.98A.5.5 0 0 1 0 15.5v-14a.5.5 0 0 1 .402-.49l5-1a.5.5 0 0 1 .196 0L10.5.99l4.902-.98a.5.5 0 0 1 .415.103zM10 1.91l-4-.8v12.98l4 .8V1.91zm1 12.98 4-.8V1.11l-4 .8v12.98zm-6-.8V1.11l-4 .8v12.98l4-.8z" />
                            </svg>
                        </div>
                        <div class="col">
                            <h5> {{$event->place}} </h5>
                        </div>
                    </div>
                    <div class="row"></div>
                </div>

                <div class="col-sm-4 event-image">
                    <div class="row">
                        <img src="https://images.unsplash.com/photo-1505373877841-8d25f7d46678?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1112&q=80" class="img-fluid rounded-start" style="height: 150px; width: 100%; object-fit: cover;">
                    </div>
                    <div class="row">
                        <!-- only show if host -->
                        <div class="row text-center"><a class="button" href="{{ url('/event/{event_id}/edit') }}">Edit Event</a></div>
                        <div class="row text-center"><a class="button" href="{{ url('/event/{event_id}/') }}">Report Event</a></div>
                    </div>
                    </div>
            </div>
        </div>
        <!-- Tabs -->
        <ul class="nav nav-pills justify-content-center" role="tablist">

            <li class="nav-item info-div mx-2 rounded">
                <button class="nav-link text-light" id="description-tab" data-bs-toggle="tab" data-bs-target="#description-content" type="button" role="tab" aria-controls="announcements-content" aria-selected="false">
                    <h3 class="m-2">Description</h3>
                </button>
            </li>

            <li class="nav-item info-div mx-2 rounded">
                <button class="nav-link text-light" id="announcements-tab" data-bs-toggle="tab" data-bs-target="#announcements-content" type="button" role="tab" aria-controls="announcements-content" aria-selected="false">
                    <h3 class="m-2">Announcements</h3>
                </button>
            </li>
            <li class="nav-item info-div mx-2 rounded">
                <button class="nav-link text-light" id="forum-tab" data-bs-toggle="tab" data-bs-target="#forum-content" type="button" role="tab" aria-controls="forum-content" aria-selected="false">
                    <h3 class="m-2">Forum</h3>
                </button>
            </li>
            <li class="nav-item info-div mx-2 rounded">
                <button class="nav-link text-light" id="participants-tab" data-bs-toggle="tab" data-bs-target="#participants-content" type="button" role="tab" aria-controls="participants-content" aria-selected="false">
                    <h3 class="m-2">Participants</h3>
                </button>
            </li>
        </ul>

        <!-- Tab contents -->
        <div class="tab-content bg-light text-dark rounded px-3 pt-3 pb-1 m-2" id="nav-tabContent">
            <div class="tab-pane fade show active" id="description-content" role="tabpanel" aria-labelledby="description-tab">
                <h3>Description</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Nunc mattis enim ut tellus elementum sagittis. Est pellentesque elit ullamcorper dignissim. Tellus elementum sagittis vitae et leo duis ut. Tempus urna et pharetra pharetra massa massa ultricies. Duis ultricies lacus sed turpis tincidunt id aliquet risus feugiat. Neque sodales ut etiam sit amet nisl purus. Dictum varius duis at consectetur lorem donec massa sapien. Amet massa vitae tortor condimentum lacinia quis vel eros. Morbi non arcu risus quis. Sed lectus vestibulum mattis ullamcorper velit sed ullamcorper morbi. Aliquam vestibulum morbi blandit cursus. Dui nunc mattis enim ut tellus elementum sagittis vitae et.</p>
                <p>Vulputate eu scelerisque felis imperdiet proin fermentum leo vel. Eros in cursus turpis massa tincidunt. Purus ut faucibus pulvinar elementum integer enim neque volutpat ac. Mi ipsum faucibus vitae aliquet. Pretium aenean pharetra magna ac placerat. Fermentum odio eu feugiat pretium nibh ipsum consequat nisl. Placerat in egestas erat imperdiet sed euismod nisi porta lorem. Eu volutpat odio facilisis mauris. Accumsan lacus vel facilisis volutpat est velit. Ullamcorper eget nulla facilisi etiam dignissim diam. Ipsum faucibus vitae aliquet nec ullamcorper sit amet risus. Amet nisl purus in mollis nunc. Sagittis nisl rhoncus mattis rhoncus urna neque viverra justo nec.</p>
            </div>

            <div class="tab-pane fade" id="announcements-content" role="tabpanel" aria-labelledby="announcements-tab">
                <h3>Announcements</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Nunc mattis enim ut tellus elementum sagittis. Est pellentesque elit ullamcorper dignissim. Tellus elementum sagittis vitae et leo duis ut. Tempus urna et pharetra pharetra massa massa ultricies. Duis ultricies lacus sed turpis tincidunt id aliquet risus feugiat. Neque sodales ut etiam sit amet nisl purus. Dictum varius duis at consectetur lorem donec massa sapien. Amet massa vitae tortor condimentum lacinia quis vel eros. Morbi non arcu risus quis. Sed lectus vestibulum mattis ullamcorper velit sed ullamcorper morbi. Aliquam vestibulum morbi blandit cursus. Dui nunc mattis enim ut tellus elementum sagittis vitae et.</p>
                <p>Vulputate eu scelerisque felis imperdiet proin fermentum leo vel. Eros in cursus turpis massa tincidunt. Purus ut faucibus pulvinar elementum integer enim neque volutpat ac. Mi ipsum faucibus vitae aliquet. Pretium aenean pharetra magna ac placerat. Fermentum odio eu feugiat pretium nibh ipsum consequat nisl. Placerat in egestas erat imperdiet sed euismod nisi porta lorem. Eu volutpat odio facilisis mauris. Accumsan lacus vel facilisis volutpat est velit. Ullamcorper eget nulla facilisi etiam dignissim diam. Ipsum faucibus vitae aliquet nec ullamcorper sit amet risus. Amet nisl purus in mollis nunc. Sagittis nisl rhoncus mattis rhoncus urna neque viverra justo nec.</p>
            </div>

            <div class="tab-pane fade" id="forum-content" role="tabpanel" aria-labelledby="forum-tab">
                <h3>Forum</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Nunc mattis enim ut tellus elementum sagittis. Est pellentesque elit ullamcorper dignissim. Tellus elementum sagittis vitae et leo duis ut. Tempus urna et pharetra pharetra massa massa ultricies. Duis ultricies lacus sed turpis tincidunt id aliquet risus feugiat. Neque sodales ut etiam sit amet nisl purus. Dictum varius duis at consectetur lorem donec massa sapien. Amet massa vitae tortor condimentum lacinia quis vel eros. Morbi non arcu risus quis. Sed lectus vestibulum mattis ullamcorper velit sed ullamcorper morbi. Aliquam vestibulum morbi blandit cursus. Dui nunc mattis enim ut tellus elementum sagittis vitae et.</p>
                <p>Vulputate eu scelerisque felis imperdiet proin fermentum leo vel. Eros in cursus turpis massa tincidunt. Purus ut faucibus pulvinar elementum integer enim neque volutpat ac. Mi ipsum faucibus vitae aliquet. Pretium aenean pharetra magna ac placerat. Fermentum odio eu feugiat pretium nibh ipsum consequat nisl. Placerat in egestas erat imperdiet sed euismod nisi porta lorem. Eu volutpat odio facilisis mauris. Accumsan lacus vel facilisis volutpat est velit. Ullamcorper eget nulla facilisi etiam dignissim diam. Ipsum faucibus vitae aliquet nec ullamcorper sit amet risus. Amet nisl purus in mollis nunc. Sagittis nisl rhoncus mattis rhoncus urna neque viverra justo nec.</p>
            </div>

            <div class="tab-pane fade" id="participants-content" role="tabpanel" aria-labelledby="participants-tab">
                <h3>Participants</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Nunc mattis enim ut tellus elementum sagittis. Est pellentesque elit ullamcorper dignissim. Tellus elementum sagittis vitae et leo duis ut. Tempus urna et pharetra pharetra massa massa ultricies. Duis ultricies lacus sed turpis tincidunt id aliquet risus feugiat. Neque sodales ut etiam sit amet nisl purus. Dictum varius duis at consectetur lorem donec massa sapien. Amet massa vitae tortor condimentum lacinia quis vel eros. Morbi non arcu risus quis. Sed lectus vestibulum mattis ullamcorper velit sed ullamcorper morbi. Aliquam vestibulum morbi blandit cursus. Dui nunc mattis enim ut tellus elementum sagittis vitae et.</p>
                <p>Vulputate eu scelerisque felis imperdiet proin fermentum leo vel. Eros in cursus turpis massa tincidunt. Purus ut faucibus pulvinar elementum integer enim neque volutpat ac. Mi ipsum faucibus vitae aliquet. Pretium aenean pharetra magna ac placerat. Fermentum odio eu feugiat pretium nibh ipsum consequat nisl. Placerat in egestas erat imperdiet sed euismod nisi porta lorem. Eu volutpat odio facilisis mauris. Accumsan lacus vel facilisis volutpat est velit. Ullamcorper eget nulla facilisi etiam dignissim diam. Ipsum faucibus vitae aliquet nec ullamcorper sit amet risus. Amet nisl purus in mollis nunc. Sagittis nisl rhoncus mattis rhoncus urna neque viverra justo nec.</p>
            </div>
        </div>
</section>

@endsection
