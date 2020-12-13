@extends('layouts.frontend_master')
@section('css')
<style>
    .error-message {
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

            <form action="{{ route('update.password') }}" method="POST" enctype="multipart/form-data">
                <!-- de truyen du lieu -->
                {{ csrf_field() }}
                <div class="form-group">
                    <label><b>Current password<span class="obligatory"> (*)</span></b></label>
                    <input class="form-control" type="password" name="old_password" />
                </div>
                @if (count($errors) > 0)
                <div class="error-message">{{ $errors->first('old_password') }}</div>
                @endif

                <div class="form-group">
                    <label><b>New password<span class="obligatory"> (*)</span></b></label>
                    <input class="form-control" type="password" name="new_password" />
                </div>
                @if (count($errors) > 0)
                <div class="error-message">{{ $errors->first('new_password') }}</div>
                @endif

                <div class="form-group">
                    <label><b>Confirm new password<span class="obligatory"> (*)</span></b></label>
                    <input class="form-control" type="password" name="cf_password" />
                </div>
                @if (count($errors) > 0)
                <div class="error-message">{{ $errors->first('cf_password') }}</div>
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

@endsection