@extends('layouts.app')

@section('title', 'Browse')

@section('content')

<section id="browse ">
    <h1>Browse</h1>

    <div class="row gap-5">
        <div class="col-md-2 md-2 border rounded py-2 bg-light text-dark">

            <h3 class="m-1">Search event:</h3>
            <input type="text" placeholder="Search for names.."></input>
            <!-- search event methods-->
            <h3 class="m-1"> Order By: </h3>

            <div>
                <h5 class="m-2">Start Date:</h5>
                <button type="button" class="btn btn-dark m-2"> &#11014</button>
                <button type="button" class="btn btn-dark  m-2"> &#11015</button>
            </div>
            <div>
                <h5 class="m-2">End Date:</h5>
                <button type="button" class="btn btn-dark  m-2"> &#11014</button>
                <button type="button" class="btn btn-dark  m-2"> &#11015</button>
            </div>

            <div>
                <h5 class="m-2">Duration:</h5>
                <button type="button" class="btn btn-dark  m-2"> &#11014</button>
                <button type="button" class="btn btn-dark  m-2"> &#11015</button>
            </div>
        </div>


        <div class="col-md-2 w-75 border rounded py-2 bg-light text-dark align-center">
            <h3 class="m-1">Events:</h3>
            @foreach ($eventg as $eventG)
            <div>
                <h3>{{$event->name}}</h3>
                <h2>{{$event->startdate}} - {{$event->enddate}}  in {{$event->place}}</h2>

            </div>
            @endforeach

        </div>
    </div>
</section>

@endsection