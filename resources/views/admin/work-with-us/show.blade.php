@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="white-box">
                <div class="">
                    <h2 class="m-b-0 m-t-0">{{$data->title}}</h2>
                    <hr>
                    <div class="row">

                        <div class="col-lg-9 col-md-9 col-sm-6 m-b-20">
                            <h4><strong class="text-success"> </strong></h4>
                        </div>

                        <div class="col-lg-9 col-md-9 col-sm-6 m-b-20">
                            <h4 class="box-title ">
                                Email
                            </h4>
                            <p class="col-md-11"
                               style="word-wrap: break-word; white-space: pre-line">{{$data->email}}</p>
                        </div>

                        <div class="col-lg-9 col-md-9 col-sm-6 m-b-20">
                            <h4 class="box-title ">
                                Message
                            </h4>
                            <p class="col-md-11"
                               style="word-wrap: break-word; white-space: pre-line">{{$data->message}}</p>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 m-b-20">
                            <h3 class="box-title">Files</h3>
                            <div class="gallery">
                                @foreach($data->image as $key)
                                    @if($key->ext == 'pdf')
                                         <a href="{{asset("uploads/$key->image")}}" class="btn btn-info" style="color:white;" download> {{$key->origin_name}}</a>
                                    @endif
                                        @if($key->ext == 'jpg' or $key->ext == 'jpeg' or $key->ext == 'png' or $key->ext == 'bmp' or $key->ext == 'tiff')
                                            <a href="{{asset("uploads/$key->image")}}"  class="btn" style="color:white;">
                                                <img src="{{asset("uploads/$key->image")}}"
                                                     class="card img-responsive m-l-15 img-thumbnail"
                                                     style="display: inline-block; width: 200px; height: 200px;"/>
                                            </a>
                                        @endif
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('header')
    <link rel="stylesheet" href="{{ asset("assets/plugins/dbLightbox/dist/simpleLightbox.min.css") }}">
@endpush

@push('footer')
    <script src="{{ asset("assets/plugins/dbLightbox/dist/simpleLightbox.js") }}"></script>
    <script !src="">
        $('.gallery a').simpleLightbox();
    </script>
@endpush










