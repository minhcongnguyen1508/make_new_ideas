<head>
  <style>
    .img-sm {
      width: 46px;
      height: 46px;
      border-radius: 50%;
    }

    p {
      text-align: justify;
    }

    .media-block .media-left {
      display: block;
      float: left;
    }

    .media-block .media-right {
      float: right;
    }

    .media-block .media-body {
      display: block;
      overflow: hidden;
      width: auto;
    }

    .mar-top {
      margin-top: 5px;

    }

    .mar-bottom {
      margin-bottom: 30px;
    }

    .mar-btm {
      margin-left: 12px;
    }
  </style>
</head>

<div class="container bootdey">
  <div class="col-md-12 bootstrap snippets">
    <form id="form-submit" action="{{route('comment.create', ['id' => $story[0]->id])}}" method="POST" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="panel-body">
        <textarea name="content" id="comment" class="form-control" rows="2" placeholder="What are you thinking?"></textarea>
        <div class="mar-top  clearfix">
          <button id="cmt-submit" class="btn btn-sm btn-primary pull-right mar-bottom" type="submit" disabled>
            <i class="fa fa-pencil fa-fw"></i> Comments
          </button>
          <a class="btn btn-trans btn-icon fa fa-video-camera add-tooltip" href="#"></a>
          <a class="btn btn-trans btn-icon fa fa-camera add-tooltip" href="#"></a>
          <a class="btn btn-trans btn-icon fa fa-file add-tooltip" href="#"></a>
        </div>
      </div>
      <form>
        <div>
          <!-- Newsfeed Content -->
          <!--===================================================-->
          <div class="media-block">
            <div class="media-block">
              @foreach($comments as $cmt)

              @if($cmt->user->avatar)
              <a class="media-left" href="#"><img class="rounded-circle" src="{{asset('avatars/' . $cmt->user->avatar)}}" width="50"></a>
              @else
              <a class="media-left" href="#"><img class="rounded-circle" src="{{asset('avatars/avatar_none.png')}}" width="50"></a>
              @endif
              <div class="media-body">
                <div class="mar-btm">
                  <small class=""> <a href="#">{{$cmt->user->username}}</a> <span class="text-muted d-block">{{$cmt->created_at}}</span>
                  </small>
                </div>
                <p>{{$cmt->content}}</p>
                <div class="pad-ver">
                  <div class="btn-group">
                    <a class="btn btn-sm btn-default btn-hover-success active" href="#"><i class="fa fa-thumbs-up"></i></a>
                    <a class="btn btn-sm btn-default btn-hover-danger" href="#"><i class="fa fa-thumbs-down"></i></a>
                  </div>
                  <button type="submit" class="btn btn-sm btn-default btn-hover-primary"> Comments </button>
                </div>
                <hr>
              </div>
              @endforeach
            </div>
          </div>
          <!-- End Newsfeed Content -->
        </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('textarea#comment').on('keyup', function() {
      if ($('#form-submit textarea#comment').val() == '') {
        $("#cmt-submit").attr("disabled", true);
      } else {
        $("#cmt-submit").attr("disabled", false);
      }
    })
  });
</script>