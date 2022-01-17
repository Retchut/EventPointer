@extends('layouts.app')

@section('title', 'editevent')

@section('content')

    <section id="edit_event">
        <h1>Edit Event</h1>
        <div class="row gap-5">
            <div class="h-50 col-md-2 md-2 ms-3 border rounded p-3 border-primary align-center">
                <h4 class="mb-3">Previous configuration:</h4>
                <p> <b>Name:</b> {{ $event->eventname }}</p>
                <p> <b>Start Date:</b> {{ $event->startdate }}</p>
                <p> <b>End Date:</b> {{ $event->enddate }}</p>
                <p> <b>Place:</b> {{ $event->place }}</p>
                <p> <b>Even State:</b> {{ $event->eventstate }}</p>
                <p> <b>Private:</b> {{ $event->isprivate }}</p>
            </div>


            <div class="col-md-1 w-75 border rounded py-2 bg-light text-dark align-center border-primary">
                <div class=" mb-3">
                    <h3 class="m-1">Please enter new event details:</h3>
                </div>
                <div class="col">
                    <form method="POST" action="{{ route('event.update', $event->id) }}">
                        {{ csrf_field() }}

                        <div class="form-group mb-2">
                            <label for="eventname">Event Name</label>
                            <input type="text" class="form-control" id="eventname" name="eventname">
                        </div>


                        <div class="form-group mb-2">
                            <label for="event_place">Place</label>
                            <input type="text" class="form-control" id="event_place">
                        </div>

                        <div class="form-group mb-2">
                            <label for="event_start_date"> Start-Date</label>
                            <input id="start_date" class="form-control" type="date">
                        </div>

                        <div class="form-group mb-2">
                            <label for="event_end_date"> End-Date</label>
                            <input id="end_date" class="form-control" type="date">
                        </div>


                        <div class="form-group mb-2">
                            <label for="event_state">State</label>
                            <select class="form-control" id="event_state">
                                <option value="1">Scheduled</option>
                                <option value="2">Finished</option>
                                <option value="3">Cancelled</option>
                                <option value="4" selected>Ongoing</option>

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="private_event">Private</label>
                            <select class="form-control" id="private_event">
                                <option value="1">Yes</option>
                                <option value="0" selected>No</option>

                            </select>
                        </div>

                        <div class="row m-2 p-3">
                            <div class="col-11">
                                <button type="button" class="btn btn-danger"><a class="text-light" href="{{ url('/event/'.$event->id.'/edit/delete') }}">Delete Event</a></button>

                            </div>
                            <div class="col-1">
                                <a class="text-light" >
                                    <button type="submit" class="btn btn-success" style="width:140%; margin-right: 0.5rem">Save Changes</button>
                                </a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>



        </div>


    </section>

@endsection
