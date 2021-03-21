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
                                <label for="title">Title <strong class="text-danger"> &#42; </strong> </label>
                                @error('title')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="title"
                                       placeholder="Title" name="title" value="{{$data->title}}" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Description <strong class="text-danger">
                                        &#42; </strong></label>
                                @error('description')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <textarea name="description" id="description" cols="30" rows="10" class="form-control"
                                          style="resize: none;" required>{{$data->description}}</textarea>
                            </div>

{{--                            <div class="form-group">--}}
{{--                                <label for="category">Category<strong class="text-danger"> &#42; </strong> </label>--}}
{{--                                @error('category')--}}
{{--                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>--}}
{{--                                @enderror--}}
{{--                                <select name="category_id" id="category_id" class="form-control">--}}
{{--                                    @foreach($category as $key)--}}
{{--                                        <option value="{{$key->id}}"--}}
{{--                                                @if($data->category_id == $key->id) selected @endif>{{$key->name}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
                            <a href='{{asset("uploads/$data->pdf_path")}}' class="btn btn-info" style="color:white;" download>Download PDF</a>
                            <div class="form-group">
                                <label for="logo">Upload PDF</label>
                                @error('pdf_path')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="file" id="pdf_path" name="pdf_path" />
                            </div>
                            <div class="form-group">
                                <label for="description">Link</label>
                                @error('link')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" name="link" id="link" class="form-control" value="{{$data->link}}">
                            </div>
                            <div class="form-group">
                                <label for="description">Link(web)</label>
                                @error('link')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" name="link_web" id="link_web" class="form-control" value="{{$data->link_web}}">
                            </div>

                            <div class="form-group">
                                <label for="logo">Upload Image </label>
                                @error('path')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="hidden" name="path" value="{{ $data->path }}">
                                <input type="file" id="path" name="imagePath" class="dropify" value="{{ $data->path }}" data-default-file='{{asset("uploads/$data->path")}}'/>
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
@endsection

@push('header')
    <!-- Dropify plugins css -->
    <link rel="stylesheet" href="{{asset('assets/plugins/dropify/dist/css/dropify.min.css')}}">
    <!-- jQuery file upload -->
    <script src="{{asset('assets/plugins/dropify/dist/js/dropify.min.js')}}"></script>

    <!--This is a datatable style -->
    <link href="{{asset('assets/plugins/datatables/media/css/dataTables.bootstrap.css')}}" rel="stylesheet"
          type="text/css"/>
@endpush

@push('footer')

    <script>
        $('.dropify').dropify();

        $('#datatable').DataTable();
    </script>
@endpush

