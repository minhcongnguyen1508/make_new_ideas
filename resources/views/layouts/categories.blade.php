<div class="container" style="padding-top: 10px; margin-bottom: 20px;">
  <ul class="list-group flex-md-row" style="overflow: auto; list-style-type: none;">

    @foreach($category ?? '' as $key => $data)
      <li class="m-l-200">
        <a class="nav-link btn" href="#">{{$data->name}}</a>
      </li>
		@endforeach
    
  </ul>

</div>
