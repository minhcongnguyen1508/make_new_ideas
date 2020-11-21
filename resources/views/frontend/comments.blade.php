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
                    <a cmt_id="{{$cmt->id}}" data-type="like_cmt" class="like btn btn-sm btn-default active">
                      <i class="icon fa fa-thumbs-up"></i>
                    </a>
                    <a cmt_id="{{$cmt->id}}" data-type="unlike_cmt" class="unlike btn btn-sm btn-default">
                      <i class="icon fa fa-thumbs-down"></i>
                    </a>
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
  function countLike() {
    $.each($('a.like'), function() {
      var cmt_id = $(this).attr('cmt_id');
      var like = this;

      $.ajax({
        url: "./count_like_cmt/" + cmt_id,
        success: function(data) {
          $(like).children('i').html(data);
        },
        error: function(msg) {
          console.log(msg)
        }
      });

      $.ajax({
        url: "./get_status_like_cmt/" + cmt_id,
        success: function(data) {
          if (data == 'liked') {
            $(like).css("color", "#025d45")
          } else {
            $(like).css("color", "grey")
          }
        },
        error: function(msg) {}
      });
    });

    $.each($('a.unlike'), function() {
      var cmt_id = $(this).attr('cmt_id');
      var unlike = this;

      $.ajax({
        url: "./count_unlike_cmt/" + cmt_id,
        success: function(data) {
          $(unlike).children('i').html(data);
        },
        error: function(msg) {}
      });

      $.ajax({
        url: "./get_status_like_cmt/" + cmt_id,
        success: function(data) {
          if (data == 'unliked') {
            $(unlike).css("color", "#025d45")
          } else {
            $(unlike).css("color", "grey")
          }
        },
        error: function(msg) {}
      });
    });
  }

  $(document).ready(function() {
    $('textarea#comment').on('keyup', function() {
      if ($('textarea#comment').val() == '') {
        $("#cmt-submit").attr("disabled", true);
      } else {
        $("#cmt-submit").attr("disabled", false);
      }
    });
    countLike()
  });

  $('body').on('click', 'a.like', function() {
    var cmt_id = $(this).attr('cmt_id');
    var url = './like_cmt/' + cmt_id;
    var like = this;

    $.ajax({
      url: url,
      context: document.body,
      method: 'POST',
      success: function(data) {
        $(like).css("color", "#025d45")
        $(like).siblings().css('color', 'grey')
        countLike()
      },
      error: function(msg) {}
    });
  });

  $('body').on('click', 'a.unlike', function() {
    var cmt_id = $(this).attr('cmt_id');
    var url = './unlike_cmt/' + cmt_id;
    var unlike = this;

    $.ajax({
      url: url,
      context: document.body,
      method: 'POST',
      success: function(data) {
        $(unlike).css("color", "#025d45")
        $(unlike).siblings().css('color', 'grey')
        countLike()
      },
      error: function(msg) {}
    });
  });
</script>