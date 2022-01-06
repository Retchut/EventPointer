@extends('layouts.app')

@section('content')
<div class="editUser" style="padding-left: 30%; padding-top: 5%">
    <form method="POST" action="{{ route('user.update', $user->id) }}">
            {{ csrf_field() }}
            
            <div class="form-group" style="width:80%">
                <h1> Edit User</h1>
                <br>
                <input type="hidden" class="form-control" id="id" name="id" value="{{$user->id}}" >
            <div>
                <div class="form-group" style="width: 40%; display: inline-block;">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="{{$user->name}}" >
                </div>
                <div class="form-group" style="width: 40%; display: inline-block">
                    <label for="address">Email</label>
                    <input type="email" class="form-control" id="address" name="address" placeholder="{{$user->email}}" >
                </div>
            </div>
            <div>
                <div class="form-group" style="width: 40%; display: inline-block;">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" >
                </div>
                <div class="form-group" style="width: 40%; display: inline-block">
                    <label for="password">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" >
                </div>
                <div class="form-group" style="width: 40%; display: inline-block;">
                    <label for="profilePictureUrl">Profile Picture (URL)</label>
                    <input type="profilepictureurl" class="form-control" id="profilepictureurl" name="profilePictureUrl" placeholder="Profile Picture URL" >
                </div>
            </div>
        </div>
        <br>
        <div class="d-flex justify-content-end row-sm-1  m-2 p-3">
            <button type="submit" class="btn btn-success" style="width:15%; margin-right: 0.5rem">Save Changes</button>
        </div>
        
    </form>

</div>
@endsection