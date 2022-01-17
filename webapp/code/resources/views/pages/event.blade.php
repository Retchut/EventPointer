@extends('layouts.app')

@section('title', 'Event')

@section('content')

    <section id="event">
        <div class="container-fluid p-4">
            <div class="event-details pb-5">
                <div class="row">
                    <div class="col-sm-8 event-info">
                        <h1 class="font-weight-bold pb-2">{{ $event->eventname }}</h1>
                        <div class="row mb-2">
                            <div class="col-1 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-calendar-event text-center" viewBox="0 0 16 16">
                                    <path
                                        d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" />
                                    <path
                                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                                </svg>
                            </div>
                            <div class="col-sm-auto my-auto">
                                <h5 class="my-auto"> {{ $event->startdate }} - {{ $event->enddate }}</h5>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-1 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-map" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M15.817.113A.5.5 0 0 1 16 .5v14a.5.5 0 0 1-.402.49l-5 1a.502.502 0 0 1-.196 0L5.5 15.01l-4.902.98A.5.5 0 0 1 0 15.5v-14a.5.5 0 0 1 .402-.49l5-1a.5.5 0 0 1 .196 0L10.5.99l4.902-.98a.5.5 0 0 1 .415.103zM10 1.91l-4-.8v12.98l4 .8V1.91zm1 12.98 4-.8V1.11l-4 .8v12.98zm-6-.8V1.11l-4 .8v12.98l4-.8z" />
                                </svg>
                            </div>
                            <div class="col-sm-auto my-auto">
                                <h5 class="my-auto"> {{ $event->place }} </h5>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-1 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-person-badge" viewBox="0 0 16 16">
                                    <path
                                        d="M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                    <path
                                        d="M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0h-7zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5v10.795a4.2 4.2 0 0 0-.776-.492C11.392 12.387 10.063 12 8 12s-3.392.387-4.224.803a4.2 4.2 0 0 0-.776.492V2.5z" />
                                </svg>
                            </div>
                            <div class="col-sm-auto my-auto">

                                <h5 class="my-auto"> Hosts:
                                    @foreach ($hosts as $host)
                                        <a class = "m-2 .text-white  link-light" href="{{ url('/user/' . $host->id) }}">
                                            {{ $host->username }}
                                        </a>
                                    @endforeach

                                </h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 event-image">
                        <div class="row justify-content-center mb-2">
                            <img src="https://images.unsplash.com/photo-1505373877841-8d25f7d46678?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1112&q=80"
                                class="img-fluid rounded-start" style="height: 150px; width: 100%; object-fit: cover;">
                        </div>
                        <div class="row justify-content-center">
                            <!-- only show if host -->
                            <div class="row-sm-auto text-center mb-1"><a class="btn btn-sm btn-outline-primary"
                                    href="{{ url('/event/' . $event->id) . '/edit' }}">Edit Event</a></div>
                            <div class="row-sm-auto text-center"><a class="btn btn-sm btn-outline-danger"
                                    href="{{ url('/event/' . $event->id) . '/report' }}">Report Event</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tabs -->
            <ul class="nav nav-tabs justify-content-center">

                <li class="nav-item m-2 rounded">
                    <button class="nav-link rounded-top active" id="description-tab" data-bs-toggle="tab"
                        data-bs-target="#description-content" type="button" role="tab" aria-controls="announcements-content"
                        aria-selected="false">
                        <h3 class="m-2">Description</h3>
                    </button>
                </li>

                <li class="nav-item m-2 rounded">
                    <button class="nav-link text-light rounded-top" id="announcements-tab" data-bs-toggle="tab"
                        data-bs-target="#announcements-content" type="button" role="tab"
                        aria-controls="announcements-content" aria-selected="false">
                        <h3 class="m-2">Announcements</h3>
                    </button>
                </li>
                <li class="nav-item m-2 rounded">
                    <button class="nav-link text-light rounded-top" id="forum-tab" data-bs-toggle="tab" data-bs-target="#forum-content"
                        type="button" role="tab" aria-controls="forum-content" aria-selected="false">
                        <h3 class="m-2">Forum</h3>
                    </button>
                </li>
                <li class="nav-item m-2 rounded">
                    <button class="nav-link text-light rounded-top" id="participants-tab" data-bs-toggle="tab"
                        data-bs-target="#participants-content" type="button" role="tab" aria-controls="participants-content"
                        aria-selected="false">
                        <h3 class="m-2">Participants</h3>
                    </button>
                </li>
            </ul>

            <!-- Tab contents -->
            <div class="tab-content text-dark rounded px-3 pt-3 pb-1 m-2" id="nav-tabContent">
                <div class="tab-pane fade active show overflow-auto" id="description-content" role="tabpanel"
                    aria-labelledby="description-tab">
                    <h3 class=mb-3>Description</h3>
                    {{ $event->event_description }}
                </div>

                <div class="tab-pane fade pb-3" id="announcements-content" role="tabpanel"
                    aria-labelledby="announcements-tab">
                    <h3 class=mb-3>Announcements</h3>

                    @if (count($announcements) > 0)
                        @include('partials.announcements',$announcements)
                    @else
                        <p>
                            No announcements yet.
                        </p>
                    @endif
                </div>

                <div class="tab-pane fade pb-3" id="forum-content" role="tabpanel" aria-labelledby="forum-tab">
                    <h3 class=mb-3>Forum</h3>
                    @if (count($comments) != 0)
                        @include('partials.comments',$comments)
                    @else
                        <p>
                            No comments yet. Comments made by participants will appear here.
                        </p>
                    @endif
                </div>

                <div class="tab-pane fade pb-3" id="participants-content" role="tabpanel"
                    aria-labelledby="participants-tab">
                    <h3 class="mb-3">Participants</h3>
                    @if (count($participants) != 0)
                        @include('partials.participants',$participants)
                    @else
                        <p>
                            No one is participating in this event for now.
                        </p>
                    @endif
                </div>
            </div>
    </section>

@endsection
