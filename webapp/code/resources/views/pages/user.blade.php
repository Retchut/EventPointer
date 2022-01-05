@extends('layouts.app')

@section('title', 'User')

@section('content')

<section id="user">
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">
    <div class="container-fluid p-4">
        
        <!-- user personal data -->
        <div class="row">
            <div class="col-sm-3">
                <div class="row">
                    <h1>{{$user->username}}</h1>
                </div>
                <div class="row d-flex justify-content-center">
                    <img src="{{ $user->profilepictureurl }}" alt="profile_img" class="user-pic">
                </div>
            </div>

            <div class="col-sm-7">
                <div class="row pb-2">
                    <h1>About Me</h1>
                </div>
                <div class="row info-div user-info mx-1 bg-light text-dark">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Nunc mattis enim ut tellus elementum sagittis. Est pellentesque elit ullamcorper dignissim. Tellus elementum sagittis vitae et leo duis ut. Tempus urna et pharetra pharetra massa massa ultricies. Duis ultricies lacus sed turpis tincidunt id aliquet risus feugiat. Neque sodales ut etiam sit amet nisl purus. Dictum varius duis at consectetur lorem donec massa sapien. Amet massa vitae tortor condimentum lacinia quis vel eros. Morbi non arcu risus quis. Sed lectus vestibulum mattis ullamcorper velit sed ullamcorper morbi. Aliquam vestibulum morbi blandit cursus. Dui nunc mattis enim ut tellus elementum sagittis vitae et.</p>
                    <p>Vulputate eu scelerisque felis imperdiet proin fermentum leo vel. Eros in cursus turpis massa tincidunt. Purus ut faucibus pulvinar elementum integer enim neque volutpat ac. Mi ipsum faucibus vitae aliquet. Pretium aenean pharetra magna ac placerat. Fermentum odio eu feugiat pretium nibh ipsum consequat nisl. Placerat in egestas erat imperdiet sed euismod nisi porta lorem. Eu volutpat odio facilisis mauris. Accumsan lacus vel facilisis volutpat est velit. Ullamcorper eget nulla facilisi etiam dignissim diam. Ipsum faucibus vitae aliquet nec ullamcorper sit amet risus. Amet nisl purus in mollis nunc. Sagittis nisl rhoncus mattis rhoncus urna neque viverra justo nec.</p>
                </div>
            </div>

            <div class="col-sm-2">
                <div class="row pb-2">
                <h1>Stats</h1>
                </div>
                <div class="row info-div user-info mx-1 bg-light text-dark">
                    @foreach ($user_stats as $key => $stat)
                        @include('partials.userstat', ['key' => $key, 'stat' => $stat])
                    @endforeach
                </div>
            </div>
        </div>

        <!-- user site info -->
        <div class="row ">
            <div class="col-sm-12">
                <h1>Events</h1>
                <div class="user-events info-div bg-light text-dark rounded">
                    @if (count($events) > 0)
                        @foreach ($events as $event)
                            @include('partials.userevent', ['event' => $event])
                        @endforeach
                    @else
                        <h2 class="font-weight-bold pb-2 m-3">This user is not participating in any events</h2>
                    @endif
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
