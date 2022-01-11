@extends('layouts.app')

@section('title', 'Browse')

@section('content')

<section id="browse">
    <link href="{{ asset('css/browse.css') }}" rel="stylesheet">
    <h1>Browse</h1>

    <div class="row gap-5">
        <div class="col-md-2 md-2 border rounded py-2 bg-light text-dark">

            <h3 class="m-1">Search event:</h3>
            <form method="POST" action="{{ route('browse.search') }}">
                {{ csrf_field() }}
                <input id="parameters" type="text" name="parameters" value="{{ old('parameters') }}" required autofocus placeholder="Search for names.."></input>
            </form>    
            
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
                <select id="state-select" class="form-select form-select-lg mb-3"" multiple aria-label=" multiple select example" onchange="window.location.reload()">
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