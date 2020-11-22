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
	
<!-- End Header -->

<!--------------------------------------
MAIN
--------------------------------------->

<div class="container">
    <div class="jumbotron jumbotron-fluid mb-3 pl-0 pt-0 pb-0 bg-white position-relative">
        <h2 class="reading-list">Search List</h2>
    </div>

    <div>
       
        <div class="rl-list-posts">
            @foreach($post as $item)
            <div class="rl-item" id="post{{$item->id}}">
                <a href="{{route('story', $item->id)}}">
                    <h2 class="rl-it-title">{{$item->title}}</h2>
                    <h3 class="rl-desc">{{$item->slug}}</h3>
                </a>
                <div >
                    <a href="">
                        <h4 class="rl-aut-name">{{$item->username}}</h4>
                    </a>
                </div>
             
            </div>

            
            @endforeach
        </div>
    </div>
    
</div>

<!-- End Main -->

<script>
    $('body').on('click', '.remove', function(){
        var id = $(this).attr('id');
        $.ajax({
            
            url: "./remove/" + id,

        }).done(function(){
            location.reload(true);
        });
    });
</script>



@endsection
