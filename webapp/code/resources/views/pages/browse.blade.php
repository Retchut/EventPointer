@extends('layouts.app')

@section('title', 'Browse')

@section('content')

<section id="browse">
    <link href="{{ asset('css/browse.css') }}" rel="stylesheet">

    <h1>Browse</h1>
    <div class="row gap-5">
        <div class="col-md-2 md-2 border rounded py-2 bg-light text-dark">
            <h3 class="m-1">Search event:</h3>
            <form method="GET" action="{{ route('browse.search') }}">
                <input id="search-input" type="text" name="search_query" value="{{ old('search_query') }}" autofocus placeholder="Search for events..">
                <input type="submit" value="Search">

                <h5 class="m-2">State:</h5>
                <select id="state-select" name="event_state" class="form-select form-select-lg mb-3" multiple aria-label=" multiple select example">
                    <option selected>All</option>
                    <option value="Scheduled">Scheduled</option>
                    <option value="Ongoing">Ongoing</option>
                    <option value="Canceled">Canceled</option>
                    <option value="Finished">Finished</option>
                </select>
            </form>

            <!-- orderevents-->
            <h3 class="m-1"> Order By: </h3>
            <div>
                    <h5 class="m-2">Start Date:</h5>
                    <div class="row text-center btn btn-dark m-2 p-0 pb-1">
                        <a class="sort-buttons" href="{{ request()->fullUrlWithQuery(['sort' => 'sdate-asc']) }}">&#11014</a>
                        
                    </div>
                    <div class="row text-center btn btn-dark m-2 p-0 pb-1">
                        <a class="sort-buttons" href="{{ request()->fullUrlWithQuery(['sort' => 'sdate-desc']) }}">&#11015</a>
                    </div>
                </div>
                <div>
                    <h5 class="m-2">End Date:</h5>
                    <div class="row text-center btn btn-dark m-2 p-0 pb-1">
                        <a class="sort-buttons" href="{{ request()->fullUrlWithQuery(['sort' => 'edate-asc']) }}">&#11014</a>
                    </div>
                    <div class="row text-center btn btn-dark m-2 p-0 pb-1">
                        <a class="sort-buttons" href="{{ request()->fullUrlWithQuery(['sort' => 'edate-desc']) }}">&#11015</a>
                    </div>
                </div>

                <div>
                    <h5 class="m-2">Duration:</h5>
                    <div class="row text-center btn btn-dark m-2 p-0 pb-1">
                        <a class="sort-buttons" href="{{ request()->fullUrlWithQuery(['sort' => 'dur-asc']) }}">&#11014</a>
                    </div>
                    <div class="row text-center btn btn-dark m-2 p-0 pb-1">
                        <a class="sort-buttons" href="{{ request()->fullUrlWithQuery(['sort' => 'dur-desc']) }}">&#11015</a>
                    </div>
                </div>
        </div>


        <div class="col-md-2 w-75 border rounded py-2 bg-light text-dark align-center">
            <div class=" mb-3 bg-dark text-white">
                <h3 class="m-1">Events:</h3>
            </div>
            <div class="col" id="browse-event">
                @foreach ($events as $event)
                    @if($event->isprivate==FALSE)
                    @include('partials.browse_events')
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection