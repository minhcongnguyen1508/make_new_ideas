<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<link rel="apple-touch-icon" sizes="76x76" href={{asset('assets/img/favicon.ico')}}>
<link rel="icon" type="image/png" href={{asset('assets/img/favicon.ico')}}>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Make Ideas </title>
<base href="{{asset(' ')}}"/> 
<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport'/>
<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700|Source+Sans+Pro:400,600,700" rel="stylesheet">
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
<!-- Main CSS -->
<link href={{asset('assets/css/main.css')}} rel="stylesheet"/>
<link href="{{asset('assets/css/search.css')}}" rel="stylesheet"/>

<!-- import ajax library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- icon library  -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

</head>

<body>
  @yield('main_content')

<!--------------------------------------
JAVASCRIPTS
--------------------------------------->
<script src={{asset('assets/js/vendor/jquery.min.js')}} type="text/javascript"></script>
<script src={{asset('assets/js/vendor/popper.min.js')}} type="text/javascript"></script>
<script src={{asset('assets/js/vendor/bootstrap.min.js')}} type="text/javascript"></script>
<script src={{asset('assets/js/functions.js')}} type="text/javascript"></script>



<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"> -->


<script type="text/javascript">
      // $('body').on('keyup','#search', function(){
      //     var searchQuery = $(this).val();
      //     console.log(searchQuery);
      // });
  $(document).ready(function(){

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    function fetch_data(query=''){
      $.ajax({
        url:"{{route('live_search')}}",
        method:'GET',
        data:{query:query},
        dataType: 'json',
        success: function(data){
          // update html here
          $('.suggestions').html(data.result_data)
        }
      })
    }

    $(document).on('keyup', '#search', function(){
      var query = $(this).val();
      fetch_data(query);
    })
  });


</script>

</body>
</html>



