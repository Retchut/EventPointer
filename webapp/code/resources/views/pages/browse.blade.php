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
        <div class=" mb-3 bg-dark text-white"><h3 class="m-1">Events:</h3></div>
            <div class="col">
                @foreach ($event as $event)
                <div class="row gap-0 mb-3 ">
                    <div class="col" style="max-width: 200px;">
                        <img src="https://images.unsplash.com/photo-1505373877841-8d25f7d46678?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1112&q=80" class="img-fluid rounded-start" style="height: 150px; width: 100%; object-fit: cover;">
                    </div>
                    <div class="col-8">
                        <h2 class="font-weight-bold pb-2">{{$event->eventname}}</h2>
                        <div class="row pb-1">
                            <div class="col-1 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-event text-center"  viewBox="0 0 16 16">
                                    <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" />
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                                </svg>
                            </div>
                            <div class="col">
                                <h5> {{$event->startdate}} - {{$event->enddate}}</h5>
                            </div>
                        </div>
                        <div class="row pb-3">
                        <div class="col-1 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-map" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M15.817.113A.5.5 0 0 1 16 .5v14a.5.5 0 0 1-.402.49l-5 1a.502.502 0 0 1-.196 0L5.5 15.01l-4.902.98A.5.5 0 0 1 0 15.5v-14a.5.5 0 0 1 .402-.49l5-1a.5.5 0 0 1 .196 0L10.5.99l4.902-.98a.5.5 0 0 1 .415.103zM10 1.91l-4-.8v12.98l4 .8V1.91zm1 12.98 4-.8V1.11l-4 .8v12.98zm-6-.8V1.11l-4 .8v12.98l4-.8z" />
                                </svg>
                            </div>
                            <div class="col">
                                <h5> {{$event->place}} </h5>
                            </div>
                        </div>
                        <a class="button font-weight-bold pb-2" href="{{ url('/event/'.$event->id) }}">Find out more</a>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</section>

@endsection