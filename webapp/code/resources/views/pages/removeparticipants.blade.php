@extends('layouts.app')

@section('title', 'removeparticipants')

@section('content')

    <section id="remove_participants">
        <h1 class="p-2">Remove Participants</h1>


        <div class="col-md-1 w-75 border rounded py-2 bg-light text-dark align-center border-primary">
            <div class="mb-3 m-2">
                <h3 class="m-1 p-1">Please choose participants to remove from event:</h3>
            </div>
            <div class="col m-2 p-3">


                @foreach ($participants as $participant)

                    <div class=" p-2 m-3 row border rounded border-primary">
                        <div class="col m-auto">
                            <span class="text-bold pl-1">
                                {{ $participant->username }}
                            </span>
                        </div>
                        <div class="col d-flex justify-content-end">
                            <a class="btn btn-danger"
                                href="{{ url('/event/' . $event->id . '/removeparticipant/' . $participant->id) }}"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-x-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                    <path
                                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                </svg></a>
                        </div>
                    </div>
                @endforeach





                <div class="row mt-4 me-1 flex-row-reverse">
                    <a role = "button" href ="{{ url('/event/' . $event->id) }}" class="btn btn-success w-auto">Return</a>
                </div>
            </div>
        </div>





    </section>

@endsection
