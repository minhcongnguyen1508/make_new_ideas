@extends('layouts.frontend_master')
@section('main_content')

<!--------------------------------------
MAIN
--------------------------------------->
@include('auth.navbar')
    <div class="container pt-4 pb-4">
        <div class="row">
            <div class="col-xl-12">
                <h2 class="text-center">Make a Story</h2>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="create_form form-group" action="javascript:void(0)" data-action="{{url('post-story')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <label for="title">Title</label>
                    <input id="title" class="form-control" type="text" name="title">
                    <label for="title">Thumbnail</label>
                    <input id="thumbnail" class="form-control" type="file" name="thumbnail">
                    <label for="title">Category</label>
                    <input class="form-control" id="category_show" readonly >
                    <select class="form-control" name="category" id="category" hidden >
                        @foreach ($categories as $category)
                            <option data-name="{{$category->name}}" value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                    <label for="title">Content</label>
                    <textarea class="form-control" name="content" id="content" cols="30" rows="10" ></textarea>
                    <a class="form-control btn btn-success " id="get_category">Create</a>
                </form>
               
            </div>
        </div>
    </div>
<div hidden="hidden" class="content-to-text"></div>
@include('layouts/footer')
<script>
    $('body').on('focus','#category_show',function(){
        $('.create_form').submit();
        $('.content-to-text').html($('#content').val())
        console.log($('.content-to-text').text())
        var data_request = {query: $('.content-to-text').text()};
        $.ajax({
        url: "http://4252beec7086.ngrok.io/suggest_category",
        type: "POST",
        data: JSON.stringify(data_request),
        success: function( response ) {
            if (response['statusCode']=="200 Success!") {
                var value_response = response['category'];
                $('#category').val($(`option[data-name="${value_response}"]`).val());
                $('#category_show').val(value_response);
            }
        }
        });
    });
    $('body').on('click','#get_category',function(){
        $('.create_form').attr('action',$('.create_form').data('action'))
        $('.create_form').submit();
    });
</script>
<script src={{ url('ckeditor/ckeditor.js') }}></script>
    <script>
    CKEDITOR.replace( 'content', {
        filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl: 'ckfinder/ckfinder.html?type=Images',
        filebrowserFlashBrowseUrl: 'ckfinder/ckfinder.html?type=Flash',
        filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
        
    } );
    </script>
@stop