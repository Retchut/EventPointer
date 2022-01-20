@extends('layouts.app')

@section('content')
<div class="editUser p-4">
    <form method="POST" action="{{ route('user.update', $user->id) }}">
            {{ csrf_field() }}

            <div class="form-group">
                <h1>Edit Account</h1>
                <br>
                <input type="hidden" class="form-control" id="id" name="id" value="{{$user->id}}" >
            <div class="row justify-content-center">
                <div class="col-5 m-4">
                    <div class="form-group mb-2">
                        <label for="name">Name</label><p>
                        <input type="text" class="form-control" id="name" name="name" placeholder="{{$user->name}}" >
                    </div>
                    <div class="form-group mb-2">
                        <label for="address">Email</label><p>
                        <input type="email" class="form-control" id="address" name="address" placeholder="{{$user->email}}" >
                    </div>
                    <div class="form-group mb-2">
                        <label for="description">Description</label><p>
                        <input type="description" class="form-control" id="description" name="description" placeholder="Description" >
                    </div>
                </div>
                <div class="col-5 m-4">
                    <div class="form-group mb-2">
                        <label for="password">Password</label><p>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" >
                    </div>
                    <div class="form-group mb-2">
                        <label for="password">Confirm Password</label><p>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" >
                    </div>
                    <div class="form-group mb-2">
                        <label for="profilePictureUrl">Profile Picture (URL)</label><p>
                        <input type="profilepictureurl" class="form-control" id="profilepictureurl" name="profilePictureUrl" placeholder="Profile Picture URL" >
                    </div>
                
                </div>
            </div>
        </div>
        <br>
        <div class="d-flex justify-content-end row-sm-1 m-2 p-3">
            <button type="submit" class="btn btn-success">Save Changes</button>
        </div>

    </form>

</div>
@endsection
