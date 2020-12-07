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
        <h2 class="reading-list">Reading List</h2>
    </div>

    <div>
        @if($story != null)
        <div class="rl-list-posts">
            @foreach($story as $item)
            <div class="rl-item" id="post{{$item->id}}">
                <a href="{{route('story', $item->post_id)}}">
                    <h2 class="rl-it-title">{{$item->title}}</h2>
                    <h3 class="rl-desc">{{$item->slug}}</h3>
                </a>
                <div >
                    <a href="">
                        <h4 class="rl-aut-name">{{$item->username}}</h4>
                    </a>
                </div>
                <div >
                    <button class="item-bt">
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="#757575">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M20.48 7.45H3.46v10.13H16a.47.47 0 1 1 0 .94H3.46c-.54 
                                0-.99-.42-.99-.94V7.45c0-.52.45-.93 1-.93h17c.55 0 1 .41 1 .93v5.57a.5.5 0 0 1-1 0V7.45zM5.47 
                                10.02c0-.28.22-.5.5-.5h9.11a.5.5 0 1 1 0 1H5.97a.5.5 0 0 1-.5-.5zm.51 2.5a.5.5 0 0 0-.51.5c0 .27.23.
                                5.51.5h5.98a.5.5 0 0 0 .51-.5.5.5 0 0 0-.51-.5H5.98zm12.52 3.02c.2-.2.5-.2.7 0l1.77 1.77 1.77-1.77a.5.5 
                                0 1 1 .7.7l-1.76 1.78 1.76 1.76a.5.5 0 1 1-.7.71l-1.77-1.77-1.77 1.77a.5.5 0 0 1-.7-.7l1.76-1.77-1.76-
                                1.77a.5.5 0 0 1 0-.7z">
                            </path>
                        </svg>
                        <div class="rl-it-remove"><h4 class="remove" id="{{$item->post_id}}">Remove</h4></div>
                    </button>
                </div>
            </div>

            
            @endforeach
        </div>
        @endif
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
