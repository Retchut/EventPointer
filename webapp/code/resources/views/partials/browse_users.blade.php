<div class="row mb-4">
    <div class="col-sm-5 mx-auto">
        <img src="{{ $user->profilepictureurl }}"
            class="user-pic" style="width: 150px; height: 150px;  object-fit: cover;" alt="profile_img">
    </div>
    <div class="col-sm-7">
        <h2 class="font-weight-bold">{{ $user->username }}</h2>
        <a class="button font-weight-bold pb-2" href="{{ url('/user/'.$user->id) }}">Check out their profile</a>
    </div>
</div>
