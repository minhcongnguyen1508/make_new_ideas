@extends('layouts.frontend_master')
@section('main_content')

<!--------------------------------------
MAIN
--------------------------------------->
@include('auth.navbar')
@include('layouts/categories')
@include('layouts/header')
<div class="container pt-4 pb-4">
	<div class="row">
		<div class="col-lg-6">
			<div class="card border-0 mb-4 box-shadow h-xl-300">
                <div style="background-image: url({{$newest_stories[2]->thumbnail}}); height: 150px;    background-size: cover;    background-repeat: no-repeat;"></div>
				<div class="card-body px-0 pb-0 d-flex flex-column align-items-start">
					<h2 class="h4 font-weight-bold">
					<a class="text-dark" href="{{ route('story',$newest_stories[1]->id) }}">{{$newest_stories[1]->title}}</a>
					</h2>
					<p class="card-text" style="text-overflow: ellipsis; overflow-y: hidden;height: 50px;">
						{!!$newest_stories[1]->content!!}
					</p>
					<div>
						<small class="d-block"><a class="text-muted" href="./author.html">{!!$newest_stories[1]->username!!}</a></small>
						<small class="text-muted">{{$newest_stories[1]->created_at}} &middot; 5 min read</small>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="flex-md-row mb-4 box-shadow h-xl-300">
				<div class="mb-3 d-flex align-items-center">
					<img height="80" src="{{$newest_stories[2]->thumbnail}}">
					<div class="pl-3">
						<h2 class="mb-2 h6 font-weight-bold">
						<a class="text-dark" href="{{ route('story',$newest_stories[2]->id) }}">{{$newest_stories[2]->title}}</a>
						</h2>
						<div class="card-text text-muted small">
							{{$newest_stories[2]->username}}
						</div>
						<small class="text-muted">{{$newest_stories[2]->created_at}} &middot; 5 min read</small>
					</div>
				</div>
				<div class="mb-3 d-flex align-items-center">
					<img height="80" src="{{$newest_stories[3]->thumbnail}}">
					<div class="pl-3">
						<h2 class="mb-2 h6 font-weight-bold">
						<a class="text-dark" href="{{ route('story',$newest_stories[3]->id) }}">{{$newest_stories[3]->title}}</a>
						</h2>
						<div class="card-text text-muted small">
							{{$newest_stories[3]->username}}
						</div>
						<small class="text-muted">{{$newest_stories[3]->created_at}} &middot; 5 min read</small>
					</div>
				</div>
				<div class="mb-3 d-flex align-items-center">
					<img height="80" src="{{$newest_stories[4]->thumbnail}}">
					<div class="pl-3">
						<h2 class="mb-2 h6 font-weight-bold">
						<a class="text-dark" href="{{ route('story',$newest_stories[4]->id) }}">{{$newest_stories[4]->title}}</a>
						</h2>
						<div class="card-text text-muted small">
							{{$newest_stories[4]->username}}
						</div>
						<small class="text-muted">{{$newest_stories[4]->created_at}} &middot; 5 min read</small>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="row justify-content-between">
		<div class="col-md-8">
			<h5 class="font-weight-bold spanborder"><span>All Stories</span></h5>
			@foreach ($stories as $story)
				<div class="mb-3 d-flex justify-content-between">
					<div class="pr-3">
						<h2 class="mb-1 h4 font-weight-bold">
						<a class="text-dark" href="{{ route('story',$story->id) }}">{{$story->title}}</a>
						</h2>
						<p style="text-overflow: ellipsis; overflow-y: hidden;height: 50px;">
							<span style="">
								{!! $story->content !!}
							</span>
						</p>
						<div class="card-text text-muted small">
							{{$story->username}}
						</div>
						<small class="text-muted">{{$story->created_at}} &middot; 5 min read</small>
					</div>
					<img height="120" src="{!! $story->thumbnail !!}">
				</div>
			@endforeach
			{{ $stories->links() }}
		</div>
		<div class="col-md-4 pl-4">
            <h5 class="font-weight-bold spanborder"><span>Popular</span></h5>
			<ol class="list-featured">
				@foreach ($the_most_stories as $the_most_story)
				<li>
					<span>
						<h6 class="font-weight-bold">
							<a href="{{ route('story',$the_most_story->id) }}" class="text-dark">{{$the_most_story->title}}</a>
						</h6>
						<p class="text-muted">
							{{$the_most_story->username}}
						</p>
					</span>
				</li>
				@endforeach
			</ol>
		</div>
	</div>
</div>

@include('layouts/footer')


@stop
