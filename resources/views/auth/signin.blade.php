@extends('auth.lib')
@section('content')

<head>
  <title>Sign in </title>
</head>
<body>
	<div class="limiter">
		<div class="container-login100" style="background-color: #80ffaa">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-55 p-b-54">
        <a class="container navbar-brand text-center m-b-23" href="{{ route('homepage') }}"><img height="80" src="./assets/img/favicon.ico"></a>
					<span class="login100-form-title p-b-30">
						Sign In
					</span>
        <form class="login100-form validate-form" method="POST" action="{{url('post-login')}}">
            {{ csrf_field() }}
					<div class="wrap-input100 validate-input m-b-20" data-validate = "Your email is reauired">
						<span class="label-input100">Email</span>
						<input class="input100" type="email" name="email" placeholder="Type your email">
						<span class="focus-input100" data-symbol="&#xf206;"></span>

            @if ($errors->has('email'))
              <span class="error">{{ $errors->first('email') }}</span>
            @endif

					</div>

					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<span class="label-input100">Password</span>
						<input class="input100" type="password" name="password" placeholder="Type your password">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
            @if ($errors->has('password'))
              <span class="error">{{ $errors->first('password') }}</span>
            @endif
					</div>

					<div class="text-right p-t-8">
						<a href="#">
							Forgot password?
						</a>
					</div>

          <div class="text-left m-t-8 m-b-8">
            <input type="checkbox">
            <label class="form-label m-l-5">Remember password</label>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" type="submit">
								Sign In
							</button>
						</div>
					</div>

          <div class="flex-col-c p-t-25 p-b-10">
						<span class="txt1">
              <a href="{{url('signup')}}" class="txt2" style="font-weight: bold; font-size: 18px;">
  							Create Account
  						</a>
						</span>
					</div>

					<div class="txt1 text-center p-b-23">
						<span>
							Or Sign In Using
						</span>
					</div>

					<div class="flex-c-m">
						<a href="#" class="login100-social-item bg1">
							<i class="fa fa-facebook"></i>
						</a>

						<a href="#" class="login100-social-item bg2">
							<i class="fa fa-twitter"></i>
						</a>

						<a href="{{ URL::to('auth/google') }}" class="login100-social-item bg3">
							<i class="fa fa-google"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id="dropDownSelect1"></div>

@endsection
