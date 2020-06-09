@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">{{$title}}</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <form method="post" action="{{ $route."/". $id . "/featured-store"}}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="featured">Featured Product (up to 5)<strong class="text-danger"> &#42; </strong> </label>
                                @error('featured')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <select name="featured[]" multiple id="featured" class="form-control">
                                    @foreach($products as $key=>$val)
                                        @if($val->id != $id)
                                            <option value="{{$val->id}}">{{$val->title}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success waves-effect waves-light col-md-12">Save {{$title}}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('header')
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/dist/css/select2.css')}}">
@endpush

@push('footer')
    <script src="{{asset('assets/plugins/select2/dist/js/select2.js')}}"></script>
    <script !src="">
        $(document).ready(function () {
            let json = '{{$data}}';
            let selected = JSON.parse(json);

            $("#featured").select2();
            $('#featured').val(selected).trigger('change');
        })
    </script>
@endpush
