@extends('layouts.app')

@section('title', 'Browse')

@section('content')

<section id="browse">
    <h1 class="mb-3">Browse</h1>
    <div class="row gap-5">
        <div class="h-50 col-md-2 ms-3 border border-primary rounded p-3 bg-light text-dark align-center">
            <h2 class="m-1">Search event:</h2>
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
                <div>
                    <h5 class="m-2 mb-1">Start Date:</h5>
                    <div class="text-center btn btn-dark m-2 me-3 mt-0 ps-2 pe-2 pt-1 pb-1"><a class="sort-buttons" href="{{ request()->fullUrlWithQuery(['sort' => 'sdate-asc']) }}"">&#11014</a></div>
                    <div class="text-center btn btn-dark m-2 mt-0 ps-2 pe-2 pt-1 pb-1"><a class="sort-buttons" href="{{ request()->fullUrlWithQuery(['sort' => 'sdate-desc']) }}">&#11015</a></div>
                </div>
                <div>
                    <h5 class="m-2 mb-1">End Date:</h5>
                    <div class="text-center btn btn-dark m-2 me-3 mt-0 ps-2 pe-2 pt-1 pb-1"><a class="sort-buttons" href="{{ request()->fullUrlWithQuery(['sort' => 'edate-asc']) }}">&#11014</a></div>
                    <div class="text-center btn btn-dark m-2 mt-0 ps-2 pe-2 pt-1 pb-1"><a class="sort-buttons"href="{{ request()->fullUrlWithQuery(['sort' => 'edate-desc']) }}">&#11015</a></div>
                </div>

                <div>
                    <h5 class="m-2 mb-1">Duration:</h5>
                    <div class="text-center btn btn-dark m-2 me-3 mt-0 ps-2 pe-2 pt-1 pb-1"><a class="sort-buttons" href="{{ request()->fullUrlWithQuery(['sort' => 'dur-asc']) }}">&#11014</a></div>
                    <div class="text-center btn btn-dark m-2 mt-0 ps-2 pe-2 pt-1 pb-1"><a class="sort-buttons" href="{{ request()->fullUrlWithQuery(['sort' => 'dur-desc']) }}">&#11015</a></div>
                </div>
            </div>
        </div>


        <div class="col-md-3 w-75 border border-primary rounded p-3 bg-light text-dark align-center">
            <div class="mb-3">
                <h2 class="m-1">Events:</h2>
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
