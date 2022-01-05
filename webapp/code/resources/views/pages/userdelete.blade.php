@extends('layouts.app')

@section('title', 'Delete User')

@section('content')

<section id="delete_user">
    <h1>Delete User</h1>
    <p>
       Deleting a User is a permanent action.
    </p>
    <p>
        {{ UserController::delete($user->id); }}
    </p>
    
</section>

@endsection