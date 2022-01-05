@extends('layouts.app')

@section('title', 'Browse')

@section('content')

<section id="browse">
    <link href="{{ asset('css/browse.css') }}" rel="stylesheet">
    <h1>Browse</h1>

    <div class="row gap-5">
        <div class="col-md-2 md-2 border rounded py-2 bg-light text-dark">

            <h3 class="m-1">Search event:</h3>
            <input type="text" placeholder="Search for names.."></input>
            <!-- search event methods-->
            <h3 class="m-1"> Order By: </h3>

            <div>
                <div>
                    <h5 class="m-2">Start Date:</h5>
                    <div class="row text-center btn btn-dark m-2 p-0 pb-1"><a class="sort-buttons" href="{{ url('/browse/sdate-asc') }}">&#11014</a></div>
                    <div class="row text-center btn btn-dark m-2 p-0 pb-1"><a class="sort-buttons" href="{{ url('/browse/sdate-desc') }}">&#11015</a></div>
                </div>
                <div>
                    <h5 class="m-2">End Date:</h5>
                    <div class="row text-center btn btn-dark m-2 p-0 pb-1"><a class="sort-buttons" href="{{ url('/browse/edate-asc') }}">&#11014</a></div>
                    <div class="row text-center btn btn-dark m-2 p-0 pb-1"><a class="sort-buttons" href="{{ url('/browse/edate-desc') }}">&#11015</a></div>
                </div>

                <div>
                    <h5 class="m-2">Duration:</h5>
                    <div class="row text-center btn btn-dark m-2 p-0 pb-1"><a class="sort-buttons" href="{{ url('/browse/dur-asc') }}">&#11014</a></div>
                    <div class="row text-center btn btn-dark m-2 p-0 pb-1"><a class="sort-buttons" href="{{ url('/browse/dur-desc') }}">&#11015</a></div>
                </div>
            </div>

            <div>
                <h5 class="m-2">State:</h5>
                <select class="form-select form-select-lg mb-3"" multiple aria-label=" multiple select example">
                    <option>All</option>
                    <option value="1" selected>Scheduled</option>
                    <option value="2">Ongoing</option>
                    <option value="3">Canceled</option>
                    <option value="4">Finished</option>
                </select>
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