@extends('layouts.app')

@section('title', 'Browse')

@section('content')

<section id="browse">
    <script type="text/javascript" src="{{ asset('js/browseSort.js') }}"> </script>
    <h1>Browse</h1>

    <div class="row gap-5">
        <div class="col-md-2 md-2 border rounded py-2 bg-light text-dark">

            <h3 class="m-1">Search event:</h3>
            <input type="text" placeholder="Search for names.."></input>
            <!-- search event methods-->
            <h3 class="m-1"> Order By: </h3>

            <div id="sort-buttons">
                <div>
                    <h5 class="m-2">Start Date:</h5>
                    <button id = "sd_d" class="btn btn-dark m-2"> &#11014</button>
                    <button id = "sd_a" class="btn btn-dark  m-2"> &#11015</button>
                </div>
                <div>
                    <h5 class="m-2">End Date:</h5>
                    <button id = "ed_d" class="btn btn-dark  m-2"> &#11014</button>
                    <button id = "ed_a" class="btn btn-dark  m-2"> &#11015</button>
                </div>

                <div>
                    <h5 class="m-2">Duration:</h5>
                    <button id = "dur_d" type="button" class="btn btn-dark  m-2"> &#11014</button>
                    <button id = "dur_a" type="button" class="btn btn-dark  m-2"> &#11015</button>
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
            <div class="col">

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