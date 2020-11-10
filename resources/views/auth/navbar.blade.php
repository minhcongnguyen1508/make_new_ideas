<nav class="topnav navbar navbar-expand-lg navbar-light bg-white fixed-top">
	<div class="container">
		<a class="navbar-brand" href="{{ route('homepage') }}"><strong>Medium</strong></a>
		<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="navbar-collapse collapse" style="">
			<ul class="navbar-nav ml-auto d-flex align-items-center">

				<li class="nav-item-l-10 dropleft">
					<div class="nav-item dropleft">
						<a class="nav-link" href="#" style="color: gray;" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<svg width="1.3em" height="1.3em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z" />
								<path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z" />
							</svg>
						</a>
						<div class="dropdown-menu" style="padding-left: 8px; padding-right: 8px;">
							<!-- <form class="form-inline">
								<input class="form-control form-control-sm"  style="border: none;" type="text" placeholder="Search Medium" aria-label="Search">
							</form> -->
							<div class="form-inline">
								<input class="form-control form-control-sm" id="search" style="border: none;" type="text" placeholder="Search Medium" aria-label="Search">
							</div>

							<div class="suggestions" stype="background:#0000">

							</div>
						</div>
					</div>
				</li>

				@if(Auth::check())

				<li class="nav-itemm-l-10" style="padding: 12px;">
					<a href="#" style="color: gray;">
						<svg width="1.3em" height="1.3em" viewBox="0 0 16 16" class="bi bi-bell" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2z" />
							<path fill-rule="evenodd" d="M8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
						</svg>
					</a>
				</li>

				<li class="nav-itemm-l-10" style="padding: 12px;">
					<a href="#" style="color: gray;">
						<svg width="1.3em" height="1.3em" viewBox="0 0 16 16" class="bi bi-bookmarks" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" d="M2 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L7 13.101l-4.223 2.815A.5.5 0 0 1 2 15.5V4zm2-1a1 1 0 0 0-1 1v10.566l3.723-2.482a.5.5 0 0 1 .554 0L11 14.566V4a1 1 0 0 0-1-1H4z" />
							<path fill-rule="evenodd" d="M4.268 1H12a1 1 0 0 1 1 1v11.768l.223.148A.5.5 0 0 0 14 13.5V2a2 2 0 0 0-2-2H6a2 2 0 0 0-1.732 1z" />
						</svg>
					</a>
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						@if(Auth::user()->avatar)
						<img src="{{asset('avatars/' . Auth::user()->avatar)}}" class="rounded-circle" style="height: 40px; width: 40px;">
						@else
						<img src="{{asset('avatars/avatar_none.png')}}" class="rounded-circle" style="height: 40px; width: 40px;">
						@endif
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="{{route('user.show', ['id' => Auth::user()->id ])}}">Profile</a>
						<a class="dropdown-item" href="{{URL::to('create-story')}}">Create Story</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="{{url('logout')}}">Sign Out</a>
						{{ csrf_field() }}
					</div>
				</li>
				@else
				<li class="nav-itemm-l-10" style="padding: 10px;">
					<a class="nav-link btn btn-outline-gray" href="{{ route('signin') }}">Sign In</a>
				</li>
				<li class="nav-item m-l-10" style="padding: 10px;">
					<a class="nav-link btn btn-outline-gray" href="{{ route('signup') }}">Sign Up</a>
				</li>
				@endif
			</ul>
		</div>
	</div>
</nav>
<!-- End Navbar -->

<!-- <script>
$(document).ready(function(){
	$("button").click(function(){
		console.log("hello trang from test button click");
	})
});

</script> -->