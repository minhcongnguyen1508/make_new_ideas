@extends('layouts.frontend_master')
@section('main_content')

<!--------------------------------------
NAVBAR
--------------------------------------->
<!-- End Navbar -->
@include('auth.navbar')


<!--------------------------------------
HEADER
--------------------------------------->
<div class="container">
	<div class="jumbotron jumbotron-fluid mb-3 pl-0 pt-0 pb-0 bg-white position-relative">
		<div class="h-100 tofront">
			<div class="row justify-content-between">
				<div class="col-md-6 pt-6 pb-6 pr-6 align-self-center">
					<p class="text-uppercase font-weight-bold">
						<a class="text-danger" href="./category.html">Stories</a>
					</p>
					<h1 class="display-4 secondfont mb-3 font-weight-bold">{{ $story[0]->title }}</h1>
					<p class="mb-3">
						{{ $story[0]->slug }}
					</p>
					<div class="d-flex align-items-center">
						<img class="rounded-circle" src="/assets/img/demo/avatar2.jpg" width="70">
						<small class="ml-2">{{ $name[0]->username}} <span class="text-muted d-block">A few hours ago &middot; 5 min. read</span>
						</small>
					</div>
				</div>
				<div class="col-md-6 pr-0">
					<img src="/assets/img/demo/1.jpg">
				</div>
			</div>
		</div>
	</div>
</div>	
<!-- End Header -->

<!--------------------------------------
MAIN
--------------------------------------->
@include('frontend/content')
@include('frontend/comments')
@include('frontend/suggestion')
<!-- End Main -->


<!--------------------------------------
FOOTER
--------------------------------------->
@include('layouts.footer')

@endsection
