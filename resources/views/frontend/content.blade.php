<div class="container pt-4 pb-4">
	<div class="row justify-content-center">

		<div class="col-md-12 col-lg-10">
			<article class="article-post">
				{!! $story[0]->content !!}
			</article>
			<div class="border p-5 bg-lightblue">
				<div class="row justify-content-between">
					<div class="col-md-5 mb-2 mb-md-0">
						<h5 class="font-weight-bold secondfont">Become a member</h5>
						Get the latest news right in your inbox. We never spam!
					</div>
					<div class="col-md-7">
						<div class="row">
							<div class="col-md-12">
								<input type="text" class="form-control" placeholder="Enter your e-mail address">
							</div>
							<div class="col-md-12 mt-2">
								<button type="submit" class="btn btn-success btn-block">Subscribe</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-2 pr-2 mb-4 col-md-6">
			<div class="sticky-top text-center">
				<div class="text-muted">
					Share this
				</div>
				<div class="share d-inline-block inline">
					<!-- AddToAny BEGIN -->
					<div class="a2a_kit a2a_kit_size_20 a2a_default_style">
						<a class="a2a_dd " style="color: gray; padding: 10px;" href="https://www.addtoany.com/share">
							<svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-share" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5zm-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z"/>
							</svg>
						</a>

						<a class="a2a_button_facebook" style="padding-top: 10px;">
							<i class=" img-thumbnail fab fa-facebook fa-2x" style="color:#4c6ef5; border: none;"></i>
						</a>
						<a class="a2a_button_twitter" style="padding-top: 10px;">
							<i class=" img-thumbnail fab fa-twitter fa-2x" style="color:#4c6ef5; border: none;"></i>
						</a>

						<a class="" style="padding-top: 12px;" href="https://github.com">
							<i class=" img-thumbnail fab fa-github fa-2x" style="color: black; border: none;"></i>
						</a>

						<a style="color: gray; padding: 10px; outline: none; border:none; background-color: white;" onclick="focusMethod()">
							<svg width="1.7em" height="1.7em" viewBox="0 0 16 16" class="bi bi-chat" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
							</svg>
							<!-- <strong class="fa-stack-1x" style="font-size:70%; color: black;">25</strong> -->

						</a>

						<a id="like" data-type="like" class="btn" style="color: gray; padding: 10px; box-shadow: none;">
							<span></span>
							<svg width="1.7em" height="1.7em" viewBox="0 0 16 16" class="bi bi-heart" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
							</svg>
						</a>

						<!-- <a class="a2a_dd " href="https://www.addtoany.com/share"></a>
						<a class="a2a_button_facebook" ></a>
						<a class="a2a_button_twitter" ></a> -->

					</div>
					<script async src="https://static.addtoany.com/menu/page.js"></script>
					<!-- AddToAny END -->
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	var post_id = window.location.pathname.split("/").slice(-1)[0]
	$('body').ready(function(){
		$.ajax({
			url: "./count-like/"+post_id,
		}).done(function(data ) {
			$('#like').children('span').html(data);
		});
		
		$.ajax({
			url: "./get-status-like/"+post_id,
		}).done(function(data ) {
			if (data == 'liked') {
				$('#like').data( "type", "unlike" );
				$('#like').css("color", "red")
			}
			
		});
	});
	$('body').on('click','#like',function(){
		var url = './'+$('#like').data('type')+"/"+post_id;
		
		$.ajax({
			url: url,
			context: document.body
		}).done(function(data ) {
			if ($('#like').data('type')=='like') {
				$('#like').data( "type", "unlike" );
				$('#like').css("color", "red")
			}
			else{
				$('#like').data( "type", "like" );
				$('#like').css("color", "gray")
			}
			$('#like').children('span').html(data);
		});
	});
	focusMethod = function getFocus() {           
  		document.getElementById("comment").focus();
		// alert("Ok");
	}
</script>