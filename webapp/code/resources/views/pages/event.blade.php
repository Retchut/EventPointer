@extends('layouts.app')

@section('title', 'Event')

@section('content')

<section id="event">
    <link href="{{ asset('css/event.css') }}" rel="stylesheet">
    <div class="container-fluid p-4">
        <div class="row">
            <h1>Event Name</h1>
            <div class="col-sm-10">
                <div class="row">
                    <p>Start Date</p>
                    <p>End Date</p>
                    <p>Place</p>
                    <p>Duration</p>
                    <p>Private</p>
                    <p>Tag</p>
                </div>
            </div>
            <div class="col-sm-2">
                <!-- only show if host -->
                <div class="row text-center"><a class="button" href="{{ url('/event/{event_id}/edit') }}">Edit Event</a></div>
                <div class="row text-center"><a class="button" href="{{ url('/event/{event_id}/') }}">Report Event</a></div>
            </div>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-pills justify-content-center" role="tablist">
            <li class="nav-item info-div mx-2">

            <button class="nav-link" id="announcements-tab" data-bs-toggle="tab" data-bs-target="#announcements-content" type="button" role="tab" aria-controls="announcements-content" aria-selected="false">
                <h3 class="m-2">Announcements</h3>
            </button>
            </li>
            <li class="nav-item info-div mx-2">
                <button class="nav-link" id="forum-tab" data-bs-toggle="tab" data-bs-target="#forum-content" type="button" role="tab" aria-controls="forum-content" aria-selected="false">
                    <h3 class="m-2">Forum</h3>
                </button>
            </li>
            <li class="nav-item info-div mx-2">
                <button class="nav-link" id="participants-tab" data-bs-toggle="tab" data-bs-target="#participants-content" type="button" role="tab" aria-controls="participants-content" aria-selected="false">
                    <h3 class="m-2">Participants</h3>
                </button>
            </li>
        </ul>

        <!-- Tab contents -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="announcements-content" role="tabpanel" aria-labelledby="announcements-tab">
                <p>announcements</p>
            </div>

            <div class="tab-pane fade" id="forum-content" role="tabpanel" aria-labelledby="forum-tab">
                <p>forum</p>
            </div>

            <div class="tab-pane fade" id="participants-content" role="tabpanel" aria-labelledby="participants-tab">
                <p>participants</p>
            </div>
        </div>
</section>

@endsection
