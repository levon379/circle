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
                            <h4><strong class="text-success">Category` </strong> {{$data->category->name}}</h4>
                            <h4><strong class="text-success">Show Status` </strong> {{$data->show == 1 ? "Show" : "Don`t Show"}}</h4>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 m-b-20">
                            <h3 class="box-title">Images</h3>
                            <div class="gallery">
                                @foreach($data->image as $key)
                                    <a href="{{asset("uploads/$key->image")}}">
                                        <img src="{{asset("uploads/$key->image")}}"
                                             class="card img-responsive m-l-15 img-thumbnail"
                                             style="display: inline-block; width: 200px; height: 200px;"/>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-lg-9 col-md-9 col-sm-6 m-b-20">
                            <h4 class="box-title ">
                                Product Description
                            </h4>
                            <p class="col-md-11"
                               style="word-wrap: break-word; white-space: pre-line">{{$data->product_desc}}</p>
                        </div>

                        <div class="col-lg-9 col-md-9 col-sm-6 m-b-20">
                            <h4 class="box-title ">
                                Images Description
                            </h4>
                            <p class="col-md-11"
                               style="word-wrap: break-word; white-space: pre-line">{{$data->uses_desc}}</p>
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










