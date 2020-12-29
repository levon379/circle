@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="white-box">
                <div class="">
                    <h2 class="m-b-0 m-t-0">{{$data->title}}</h2>
                    <hr>
                    <h4>
                        Created at`
                        <span class="text-success" style="margin-left: 15px; font-size: 15px">{{$data->date}}</span>
                    </h4>
                    <hr>
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-6">
                            <img src="{{asset("uploads/$data->logo")}}" class="img-fluid img-thumbnail">
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-6">
                            <h4 class="box-title">
                                Description
                            </h4>
                            <p class="col-md-11"
                               style="word-wrap: break-word; white-space: pre-line">{{$data->description}}</p>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <h3 class="box-title m-t-40">Images</h3>
                            <div class="gallery">
                                @foreach($data->images as $key)
                                    @if($key->image != null)
                                        <a href="{{asset("uploads/$key->image")}}">
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










