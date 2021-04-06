@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">{{$title}}</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <form method="post" action="{{ $route."/".$data->id }}" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")

                            <div class="form-group">
                                <label for="title">Title<strong class="text-danger"> &#42; </strong> </label>
                                @error('title')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="title"
                                       placeholder="Title" name="title" value="{{$data->title}}" required>
                            </div>



                            <div class="form-group">
                                <label for="thumbnail">Main Image<strong class="text-danger"> &#42; </strong> </label>
                                @error('thumbnail')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="file" name="thumbnail" class="form-control dropify" id="thumbnail"
                                       placeholder="thumbnail"  data-default-file='{{asset("uploads/$data->logo")}}'>
                            </div>
                            <div class="form-group">
                                <label for="category">Category</label>
                                @error('category')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="0" @if($data->category_id == 0) selected @endif>Choose</option>
                                    @foreach($category as $key)
                                        <option value="{{$key->id}}"
                                                @if($data->category_id == $key->id) selected @endif>{{$key->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="text1">Description<strong class="text-danger"> &#42; </strong></label>
                                @error('text1')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <textarea required name="description" id="description" cols="30" rows="10" class="form-control"
                                          style="resize: none">{{$data->description}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="show">Status<strong class="text-danger"> &#42; </strong> </label>
                                @error('show')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <select name="show" id="show" class="form-control">
                                    <option value="0" @if($data->show == 0) selected @endif>Enable</option>
                                    <option value="1" @if($data->show == 1) selected @endif>Disable</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                <div class="col-xs-6">
                                    <label for="title">Price<strong class="text-danger"> &#42; </strong> </label>
                                    @error('price')
                                    <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                    @enderror
                                    <input type="text" class="form-control" id="price"
                                           placeholder="Price" name="price" value="{{$data->price}}" required>
                                </div>
                                <div class="col-xs-6">
                                    <label for="title">Currency<strong class="text-danger"> &#42; </strong> </label>
                                    @error('currency')
                                    <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                    @enderror
                                    <select name="currency" id="currency" class="form-control">
                                        @foreach(\App\Admin\Shop::$currency as $key=>$category)
                                            <option value="{{$key}}" @if($data->currency == $key) selected @endif>{{$category}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="title">Link<strong class="text-danger"> &#42; </strong> </label>
                                @error('link')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="link"
                                       placeholder="Link" name="link" value="{{$data->link}}" required>
                            </div>
                            <button type="submit" class="btn btn-success waves-effect waves-light col-md-12">
                                Save {{$title}}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--image part--}}

@endsection

@push('header')
    <!--This is a datatable style -->
    <link href="{{asset('assets/plugins/datatables/media/css/dataTables.bootstrap.css')}}" rel="stylesheet"
          type="text/css"/>

    <!-- Dropify plugins css -->
    <link rel="stylesheet" href="{{asset('assets/plugins/dropify/dist/css/dropify.min.css')}}">
    <!-- jQuery file upload -->
    <script src="{{asset('assets/plugins/dropify/dist/js/dropify.min.js')}}"></script>
@endpush

@push('footer')

    <script>
        $('.dropify').dropify();
        $('#datatable').DataTable();
        $("#price").on("keypress keyup blur",function (event) {
            //this.value = this.value.replace(/[^0-9\.]/g,'');
            $(this).val($(this).val().replace(/[^0-9\.]/g,''));
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
    </script>
@endpush
