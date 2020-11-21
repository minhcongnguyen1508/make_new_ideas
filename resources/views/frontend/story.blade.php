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

						@if ($name[0]->user_id != current_user()->id)
							<a data-href="{{url('/follow/'.$name[0]->user_id)}}" data-writer="{{$name[0]->user_id}}" id="follow" class="btn btn-outline-primary">
								Follow
							</a>
							<a data-href="{{url('/unfollow/'.$name[0]->user_id)}}" id="unfollow" class="btn btn-outline-danger">
								Unfollow
							</a>
						@endif
						
							<a id="save" data-type="save" class="btn" style="color: gray; padding: 10px; margin-left: 50px">

								<svg class="svg-icon" viewBox="0 0 20 20" width="1.7em" height="1.7em" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
									<path fill-rule="evenodd" d="M14.467,1.771H5.533c-0.258,0-0.47,0.211-0.47,0.47v15.516c0,0.414,0.504,0.634,0.802,0.331L10,13.955l4.136,4.133c0.241,0.241,0.802,0.169,0.802-0.331V2.241C14.938,1.982,14.726,1.771,14.467,1.771 M13.997,16.621l-3.665-3.662c-0.186-0.186-0.479-0.186-0.664,0l-3.666,3.662V2.711h7.994V16.621z"></path>
								</svg>
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
	var writer_id = $("#follow").data('writer');
	$( document ).ready(function() {
		
		$.ajax({
			url: "./isfollowed/"+writer_id,
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
			url: "./follow/"+writer_id,
			type:"POST",
			data:{
				writer_id:writer_id,
			}
        }).done(function() {
			$("#follow").attr('hidden','hidden');
			$("#unfollow").removeAttr('hidden');
			location.reload();
		});
	});
	$('body').on("click","#unfollow",function(){
		$.ajax({
			url: "./unfollow/"+writer_id,
			type:"DELETE",
			data:{
				writer_id:writer_id,
			}
        }).done(function() {
			$("#unfollow").attr('hidden','hidden');
			$("#follow").removeAttr('hidden');
			location.reload();
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


<script>
	var post_id = window.location.pathname.split("/").slice(-1)[0]
	$('body').ready(function(){
		
		$.ajax({
			url: "./status-save/"+ post_id,		
		}).done(function(data){
			console.log('hello trang');
			if(data == 'saved'){
				$('#save').data( "type", "unsave" );
				$('#save').css("color", "blue")
			}
		});
	});

	$('body').on('click', '#save', function(){
		var url = './'+$('#save').data('type')+"/"+post_id;
		$.ajax({
			url: url,
			context: document.body
		}).done(function(data){
			if($('#save').data('type') == 'save'){
				$('#save').data( "type", "unsave" );
				$('#save').css("color", "blue")
			}
			else{
				$('#save').data( "type", "save" );
				$('#save').css("color", "gray")
			}
			
		});
		//console.log($('#save').data('type'));
	});
</script>

<!--------------------------------------
FOOTER
--------------------------------------->
@include('layouts.footer')

@endsection


