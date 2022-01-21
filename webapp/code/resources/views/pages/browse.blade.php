@extends('layouts.app')

@section('title', 'Browse')

@section('content')

    <section id="browse">
        <h1 class="mb-3">Browse</h1>
        <div class="row gap-5">
            <div class="h-50 col-md-2 ms-3 border border-primary rounded p-3 bg-light text-dark align-center">
                <h2 class="m-1">Search event:</h2>
                <form method="GET" class="form-group" action="{{ route('browse.search') }}">
                    <input id="search-input" class="mb-2 form-control ms-2 w-75 input-sm p-1" type="text" name="search_query"
                        value="{{ old('search_query') }}" autofocus placeholder="Search for events..">

                    <h4 class="m-1">State:</h4>
                    <select id="state-select" name="event_state" class="form-select form-select-sm ms-2 mb-3 w-75" multiple
                        aria-label=" multiple select example">
                        <option selected>All</option>
                        <option value="Scheduled">Scheduled</option>
                        <option value="Ongoing">Ongoing</option>
                        <option value="Canceled">Canceled</option>
                        <option value="Finished">Finished</option>
                    </select>

                    <h4 class="m-1">Tag:</h4>
                    <select id="state-select" name="event_tag" class="form-select form-select-sm ms-2 mb-3 w-75" multiple
                        aria-label=" multiple select example">
                        <option selected>All</option>
                        <option value="1">Music </option>
                        <option value="2"> Sports</option>
                        <option value="3">Movies and TV Shows </option>
                        <option value="4">Arts and leisure </option>
                        <option value="5">Programming </option>
                        <option value="6">Lifestyle</option>
                        <option value="7">Gaming</option>
                        <option value="8"> Tech</option>
                        <option value="9">Streaming </option>
                    </select>

                    <input type="submit" value="Search" class="btn btn-sm btn-outline-success p-1 ms-2 mb-2">

                </form>

                <!-- orderevents-->
                <h3 class="m-1 mt-2"> Order By: </h3>
                <div>
                    <div>
                        <h5 class="m-2 mb-1">Start Date:</h5>
                        <div class="text-center btn btn-dark m-2 me-3 mt-0 ps-2 pe-2 pt-1 pb-1"><a class="sort-buttons"
                                href="{{ request()->fullUrlWithQuery(['sort' => 'sdate-asc']) }}"">&#11014</a></div>
                                                        <div class="
                                
                                
                                      text-center btn btn-dark m-2 mt-0 ps-2 pe-2 pt-1 pb-1"><a
                                    class="sort-buttons"
                                    href="{{ request()->fullUrlWithQuery(['sort' => 'sdate-desc']) }}">&#11015</a></div>
                    </div>
                    <div>
                        <h5 class="m-2 mb-1">End Date:</h5>
                        <div class="text-center btn btn-dark m-2 me-3 mt-0 ps-2 pe-2 pt-1 pb-1"><a class="sort-buttons"
                                href="{{ request()->fullUrlWithQuery(['sort' => 'edate-asc']) }}">&#11014</a></div>
                        <div class="text-center btn btn-dark m-2 mt-0 ps-2 pe-2 pt-1 pb-1"><a class="sort-buttons"
                                href="{{ request()->fullUrlWithQuery(['sort' => 'edate-desc']) }}">&#11015</a></div>
                    </div>

                    <div>
                        <h5 class="m-2 mb-1">Duration:</h5>
                        <div class="text-center btn btn-dark m-2 me-3 mt-0 ps-2 pe-2 pt-1 pb-1"><a class="sort-buttons"
                                href="{{ request()->fullUrlWithQuery(['sort' => 'dur-asc']) }}">&#11014</a></div>
                        <div class="text-center btn btn-dark m-2 mt-0 ps-2 pe-2 pt-1 pb-1"><a class="sort-buttons"
                                href="{{ request()->fullUrlWithQuery(['sort' => 'dur-desc']) }}">&#11015</a></div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 w-75 text-dark align-center">
                <div class="row p-3 bg-light border border-primary rounded mb-3">
                    <div class="mb-3">
                        <h2 class="m-1">Events:</h2>
                    </div>
                    <div class="col" id="browse-event">
                        @if (count($events) > 0)
                            @foreach ($events as $event)
                                @if (Auth::check() && !Auth::user()->isadmin)
                                    @if ($event->isprivate == false)
                                        @include('partials.browse_events')
                                    @endif
                                @else
                                    @include('partials.browse_events')
                                @endif
                            @endforeach
                        @else
                            <h5>No results were found for the specified query and filters.</h5>
                        @endif
                    </div>
                </div>

                <div class="row p-3 bg-light border border-primary rounded mb-3">
                    <div class="mb-3">
                        <h2 class="m-1">Users:</h2>
                    </div>
                    <div class="col" id="browse-event">
                        @if (count($users) > 0)
                            @foreach ($users as $user)
                                @if (!$user->isadmin)
                                    @include('partials.browse_users')
                                @endif
                            @endforeach
                        @else
                            <h5>No results were found for the specified query and filters.</h5>
                        @endif
                    </div>
                </div>
            <div>
        </div>
    </section>

@endsection
