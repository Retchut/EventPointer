@extends('layouts.app')

@section('title', 'Browse')

@section('content')

<section id="browse">
    <h1 class="mb-3">Browse</h1>


    <div class="row gap-5">
        <div class="h-50 col-md-2 ms-3 border border-primary rounded p-3 bg-light text-dark align-center">

            <h2 class="m-1">Search event:</h2>
            <input type="text" class="mb-3 m-1 form-control" style="width: 90%;" placeholder="Search for names..."></input>
            <!-- search event methods-->
            <h3 class="m-1"> Order By: </h3>

            <div>
                <div>
                    <h5 class="m-2 mb-1">Start Date:</h5>
                    <div class="text-center btn btn-dark m-2 me-3 mt-0 ps-2 pe-2 pt-1 pb-1"><a class="sort-buttons" href="{{ url('/browse/sdate-asc') }}">&#11014</a></div>
                    <div class="text-center btn btn-dark m-2 mt-0 ps-2 pe-2 pt-1 pb-1"><a class="sort-buttons" href="{{ url('/browse/sdate-desc') }}">&#11015</a></div>
                </div>
                <div>
                    <h5 class="m-2 mb-1">End Date:</h5>
                    <div class="text-center btn btn-dark m-2 me-3 mt-0 ps-2 pe-2 pt-1 pb-1"><a class="sort-buttons" href="{{ url('/browse/edate-asc') }}">&#11014</a></div>
                    <div class="text-center btn btn-dark m-2 mt-0 ps-2 pe-2 pt-1 pb-1"><a class="sort-buttons" href="{{ url('/browse/edate-desc') }}">&#11015</a></div>
                </div>

                <div>
                    <h5 class="m-2 mb-1">Duration:</h5>
                    <div class="text-center btn btn-dark m-2 me-3 mt-0 ps-2 pe-2 pt-1 pb-1"><a class="sort-buttons" href="{{ url('/browse/dur-asc') }}">&#11014</a></div>
                    <div class="text-center btn btn-dark m-2 mt-0 ps-2 pe-2 pt-1 pb-1"><a class="sort-buttons" href="{{ url('/browse/dur-desc') }}">&#11015</a></div>
                </div>
            </div>

            <div>
                <h5 class="m-2 mb-1">State:</h5>
                <select id="state-select" class="form-select-sm m-2 mt-0 p-2" style="width: 70%;" multiple aria-label=" multiple select example" onchange="window.location.reload()">
                    <option selected>All</option>
                    <option value="1">Scheduled</option>
                    <option value="2">Ongoing</option>
                    <option value="3">Canceled</option>
                    <option value="4">Finished</option>
                </select>
                <!-- TODO: Fix this -->
                <script>
                function change(){
                    let value = select.options[select.selectedIndex].value;
                    window.location.href = window.location.href + "/" + value;
                }
                </script>
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
