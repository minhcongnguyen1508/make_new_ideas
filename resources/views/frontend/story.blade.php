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
						@if($name[0]->avatar)
						<img class="rounded-circle" src="{{asset('avatars/' . Auth::user()->avatar)}}" width="70">
						@else
						<img class="rounded-circle" src="{{asset('avatars/avatar_none.png')}}" width="70">
						@endif
						<small class="ml-2">{{ $name[0]->username}} <span class="text-muted d-block">A few hours ago &middot; 5 min. read</span>
						</small>
						<a data-href="{{url('/follow/'.$name[0]->user_id)}}" data-writer="{{$name[0]->user_id}}" id="follow" class="btn btn-outline-primary">
							Follow
						</a>
						<a data-href="{{url('/unfollow/'.$name[0]->user_id)}}" id="unfollow" class="btn btn-outline-danger">
							Unfollow
						</a>
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
<script>
	var write_id = $("#follow").data('writer');
	$( document ).ready(function() {
		
		$.ajax({
			url: "./isfollowed/"+write_id,
		}).done(function(data ) {
			console.log(data)
			if(data > 0){
				$("#follow").attr('hidden','hidden');
			}
			else{
				$("#unfollow").attr('hidden','hidden');
			}
		});
	});
	$('body').on("click","#follow",function(){
		$.ajax({
			url: "./follow/"+write_id,
			type:"POST",
			data:{
				write_id:write_id,
			}
        }).done(function() {
			$("#follow").attr('hidden','hidden');
			$("#unfollow").removeAttr('hidden');
		});
	});
	$('body').on("click","#unfollow",function(){
		$.ajax({
			url: "./unfollow/"+write_id,
			type:"DELETE",
			data:{
				write_id:write_id,
			}
        }).done(function() {
			$("#unfollow").attr('hidden','hidden');
			$("#follow").removeAttr('hidden');
		});
	});
</script>
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