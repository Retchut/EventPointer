@extends('layouts.app')

@section('title', 'addparticipants')

@section('content')

    <section id="add_participants">
        <h1 class="p-2"> <a role="button" href="{{ url('/event/' . $event->id) }}"
                class="btn w-auto mx-3"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                  </svg></a>Add Participants
        </h1>
        <form method="GET" class="d-inline-flex w-75" action="{{ route('browse.search') }}">
            <input id="search-input" class="form-control form-control-sm me-sm-2" type="text" name="search_query"
                value="{{ old('search_query') }}" required placeholder="Search">
            <button class="btn btn-secondary btn-sm my-2 my-sm-0" type="submit">Search</button>
        </form>


    </section>

@endsection
