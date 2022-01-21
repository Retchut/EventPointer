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

            <div class="col-sm-6">
                <div class="row pb-2">
                    <h1>About Me</h1>
                </div>
                <div class="row border border-primary rounded mx-1 bg-light text-dark py-2">
                    @if(is_null($user->description))
                    <p class="m-0">This user hasn't added any description to his profile.</p>
                    @else
                    <p class="m-0">{{$user->description}}</p>
                    @endif

                </div>
            </div>

            <div class="col-sm-3">
                <div class="row pb-2">
                <h1>Stats</h1>
                </div>
                <div class="row border border-primary rounded mx-1 bg-light text-dark p-2">
                    @foreach ($user_stats as $key => $stat)
                        @include('partials.userstat', ['key' => $key, 'stat' => $stat])
                    @endforeach
                </div>
            </div>
        </div>

        <!-- user site info -->
        <div class="row ">
            <div class="col-sm-12">
                @if($user->isadmin)
                @include('partials.admin_user')
                @else
                @include('partials.normal_user')
                @endif
            </div>
        </div>

        <!-- TODO: restrict to only the user's invites -->
        @if ((Auth::user()->id == $user->id))
        <div class="d-flex justify-content-end">
        </div>
        @endif

        @if ((Auth::user()->id == $user->id ) && !(Auth::user()->isadmin))
        <div class="d-flex justify-content-end">
            <div class="row-sm-1  m-2 p-3">
                <a class="btn btn-outline-primary" href="{{ url('/user/'.@Auth::user()->id.'/edit') }}">Edit Account</a>
                <a class="btn btn-danger" href="{{ url('/user/'.@Auth::user()->id.'/delete') }}">Delete Account</a>
            </div>
        </div>
        @endif
        @if (Auth::user()->isadmin)
        <div class="d-flex justify-content-end">
            <div class="row-sm-1  m-2 p-3">
                <a class="btn btn-outline-primary" href="{{ url('/user/'.$user->id.'/edit') }}">Edit Account</a>
                <a class="btn btn-danger" href="{{ url('/user/'.$user->id.'/delete') }}">Delete Account</a>
            </div>
        </div>
        @endif
    </div>
</section>

@endsection
