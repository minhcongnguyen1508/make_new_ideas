
<div class="container pt-4 pb-4">
	<h5 class="font-weight-bold spanborder"><span>Read next</span></h5>
	<div class="row">
		<div class="col-lg-6">
			<div class="card border-0 mb-4 box-shadow h-xl-300">
				<div style="background-image: url(./assets/img/demo/3.jpg); height: 150px; background-size: cover; background-repeat: no-repeat;">
				</div>
				<div class="card-body px-0 pb-0 d-flex flex-column align-items-start">
					<h2 class="h4 font-weight-bold">
						<a class="text-dark" href="{{ route('story',$newest_stories[0]->id) }}">{{$newest_stories[0]->title}}</a>
					</h2>
					<p class="card-text" style="text-overflow: ellipsis; overflow-y: hidden;height: 50px;">
						{!!$newest_stories[0]->content!!}
					</p>
					<div>
						<small class="d-block"><a class="text-muted" href="./author.html">{!!$newest_stories[0]->username!!}</a></small>
						<small class="text-muted">{{$newest_stories[0]->created_at}} &middot; 5 min read</small>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="flex-md-row mb-4 box-shadow h-xl-300">
				<div class="mb-3 d-flex align-items-center">
					<img height="80" src="./assets/img/demo/blog4.jpg">
					<div class="pl-3">
						<h2 class="mb-2 h6 font-weight-bold">
							<a class="text-dark" href="{{ route('story',$newest_stories[1]->id) }}">{{$newest_stories[1]->title}}</a>
						</h2>
						<div class="card-text text-muted small">
							{{$newest_stories[1]->username}}
						</div>
						<small class="text-muted">{{$newest_stories[1]->created_at}} &middot; 5 min read</small>
					</div>
				</div>
				<div class="mb-3 d-flex align-items-center">
					<img height="80" src="./assets/img/demo/blog5.jpg">
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
					<img height="80" src="./assets/img/demo/blog6.jpg">
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
			</div>
		</div>
	</div>
</div>
