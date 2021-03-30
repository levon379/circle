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
                            @if($data->type != 'Main' and $data->type != 'Branding')
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
                            @endif
                            @if($data->type != 'Main')
                            <div class="form-group">
                                <label for="description">Link <strong class="text-danger"> &#42; </strong></label>
                                @error('link')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" name="link" id="link" class="form-control" value="{{$data->link}}">
                            </div>
                            @endif
                            <div class="form-group">
                                <label for="logo">Upload Video <strong class="text-danger"> &#42; </strong></label>
                                @error('path')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="file" id="path" name="path" class="" data-default-file='{{asset("uploads/$data->path")}}'/>
                            </div>
                            <video width="320" height="240" controls>
                                <source src='{{asset("uploads/$data->path")}}' type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <button type="submit" class="btn btn-success waves-effect waves-light col-md-12">
                                Save
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

