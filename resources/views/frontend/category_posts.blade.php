@extends('layouts.frontend_master')
@section('main_content')

<!--------------------------------------
MAIN
--------------------------------------->
@include('auth.navbar')
@include('layouts/categories')


<div class="container pt-4 pb-4">

	<div class="row">
    
        <div class="col-lg-12">
        <h5 class="font-weight-bold spanborder"><span>Newest story of {{$category_name[0]->name}}</span></h5>
     
        </div>
		<div class="col-lg-6">
            
			<div class="card border-0 mb-4 box-shadow h-xl-300">
                <div style="background-image: url({{$newest_stories[0]->thumbnail}}); height: 150px;    background-size: cover;    background-repeat: no-repeat;"></div>
				<div class="card-body px-0 pb-0 d-flex flex-column align-items-start">
					<h2 class="h4 font-weight-bold">
						<a class="text-dark" href="{{ route('story',$newest_stories[0]->id) }}">{{$newest_stories[0]->title}}</a>
					</h2>
					<p class="card-text" style="text-overflow: ellipsis; overflow-y: hidden;height: 50px;">
						{!!$newest_stories[0]->content!!}
					</p>
					<div>
						<small class="d-block"><a class="text-muted" href="./author.html">{!!$newest_stories[0]->username!!}</a></small>
						<small class="text-muted">{{$newest_stories[0]->created_at}}</small>
					</div>
				</div>
			</div>
		</div>
        <div class="col-lg-6">
        
			<div class="flex-md-row mb-4 box-shadow h-xl-300">
            @foreach($newest_stories as $item)
                @if($item != $newest_stories[0])
				<div class="mb-3 d-flex align-items-center">
					<img height="80" src="{{$item->thumbnail}}">
					<div class="pl-3">
						<h2 class="mb-2 h6 font-weight-bold">
						<a class="text-dark" href="{{ route('story',$item->id) }}">{{$item->title}}</a>
						</h2>
						<div class="card-text text-muted small">
							{{$item->username}}
						</div>
						<small class="text-muted">{{$item->created_at}}</small>
					</div>
				</div>
                @endif

            @endforeach
				
			</div>
            
		</div>

	</div>
</div>

<div class="container">
	<div class="row justify-content-between">
		<div class="col-md-8">
			<h5 class="font-weight-bold spanborder"><span>All Stories about {{$category_name[0]->name}}</span></h5>
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
						<small class="text-muted">{{$story->created_at}}</small>
					</div>
					<img height="120" src="{!! $story->thumbnail !!}">
				</div>
			@endforeach
			
		</div>
		<div class="col-md-8">
			{{ $stories->links() }}
		</div>
	</div>
</div>


@include('layouts/footer')


@stop
