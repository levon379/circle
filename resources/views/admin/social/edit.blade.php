@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">{{$action}} {{$title}}</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <form method="post" action="{{ $route."/".$data->id }}" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")

                            <div class="form-group">
                                <label for="name">Name <strong class="text-danger"> &#42; </strong> </label>
                                @error('name')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="name"
                                       placeholder="Name" name="name" value="{{$data->name}}" required>
                            </div>

                            <div class="form-group">
                                <label for="link">Link <strong class="text-danger"> &#42; </strong> </label>
                                @error('link')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="link"
                                       placeholder="Link" name="link" value="{{$data->link}}" required>
                            </div>

{{--                            <div class="form-group">--}}
{{--                                <label for="logo">Upload Link Logo <strong class="text-danger"> &#42; </strong></label>--}}
{{--                                @error('logo')--}}
{{--                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>--}}
{{--                                @enderror--}}
{{--                                <input type="file" id="logo" name="logo" required class="dropify" data-default-file='{{asset("uploads/$data->logo")}}' />--}}
{{--                            </div>--}}

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
@endpush

@push('footer')
    <script>
        $('.dropify').dropify();
    </script>
@endpush
