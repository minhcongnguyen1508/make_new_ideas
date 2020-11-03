<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Register Form - XpertPhp</title>
        <link href="{{url('assets/css/styles.css')}}" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                                    <div class="card-body">
                                        <form action="{{url('post-register')}}" method="POST" id="regForm">
										{{ csrf_field() }}
                                            <div class="form-group">
												<label class="small mb-1" for="inputFirstName">Full Name</label>
												<input class="form-control py-4" id="inputFirstName" type="text" name="name" placeholder="Enter Full Name" />
												 @if ($errors->has('name'))
												  <span class="error">{{ $errors->first('name') }}</span>
												  @endif
											</div>
                                            <div class="form-group">
												<label class="small mb-1" for="inputEmailAddress">Email</label>
												<input class="form-control py-4" id="inputEmailAddress" type="email" aria-describedby="emailHelp" name="email" placeholder="Enter email address" />
												@if ($errors->has('email'))
												  <span class="error">{{ $errors->first('email') }}</span>
												@endif
											</div>
											<div class="form-group">
												<label class="small mb-1" for="inputPassword">Password</label>
												<input class="form-control py-4" id="inputPassword" type="password" name="password" placeholder="Enter password" />
												@if ($errors->has('password'))
												  <span class="error">{{ $errors->first('password') }}</span>
												@endif
											</div>
                                            <div class="form-group mt-4 mb-0">
								                <button class="btn btn-primary btn-block" type="submit">Create Account</button>
											</div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="{{url('login')}}">Have an account? Go to login</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2019</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{url('assets/js/scripts.js')}}"></script>
    </body>
</html>
