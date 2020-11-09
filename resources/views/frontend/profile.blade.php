@extends('layouts.frontend_master')
@section('css')
<style>
.error-message{
    text-align: left;
    width: 100%;
    color: red;
    font-weight: normal;
}
</style>
@endsection
@section('main_content')

<!--------------------------------------
NAVBAR
--------------------------------------->
<!-- End Navbar -->
@include('auth.navbar')


<!--------------------------------------
HEADER
--------------------------------------->
<div class="container pt-4 pb-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            @if(session('success'))
            <div class="alert alert-success">
                {{session('success')}}
            </div>
            @endif

            <form action="{{ route('user.edit', ['id' => Auth::user()->id ]) }}" method="POST" enctype="multipart/form-data">
                <!-- de truyen du lieu -->
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="font-weight-bold">Username</label>
                    <input class="form-control" name="username" value="{{$user->username}}" />
                </div>
                @if (count($errors) > 0)
                <div class="error-message">{{ $errors->first('username') }}</div>
                @endif

                <div class="form-group">
                    <label class="font-weight-bold">Email</label>
                    <input class="form-control" name="email" value="{{$user->email}}" />
                </div>
                @if (count($errors) > 0)
                <div class="error-message">{{ $errors->first('email') }}</div>
                @endif

                <div class="form-group">
                    <label class="font-weight-bold">Role</label>
                    <div class="inline-block">
                        <label class="radio-inline mr-3">
                            <input class="mr-1" value="1" @if($user->role_id == 1) {{"checked"}} @endif type="radio" disabled>User
                        </label>
                        <label class="radio-inline mr-3">
                            <input class="mr-1" value="2" @if($user->role_id == 2) {{"checked"}} @endif type="radio" disabled>Writer
                        </label>
                        <label class="radio-inline mr-3">
                            <input class="mr-1" value="3" @if($user->role_id == 3) {{"checked"}} @endif type="radio" disabled>Admin
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="mr-3 font-weight-bold">Avatar</label>
                    <label class="radio-inline">
                        <input type="file" name="avatar" value="{{$user->avatar}}">
                    </label>

                    <div class="inline-block">
                        @if($user->avatar)
                        <img style="width: 200px" src="avatars/{{$user->avatar}}">
                        @endif
                    </div>
                </div>
                @if (count($errors) > 0)
                <div class="error-message">{{ $errors->first('avatar') }}</div>
                @endif
                <button type="submit" class="btn btn-dark">Edit</button>
                <form>
        </div>
    </div>
</div>
<!-- End Header -->

<!--------------------------------------
FOOTER
--------------------------------------->
@include('layouts.footer')

@endsection