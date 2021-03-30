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
                            <h4><strong class="text-success">Contact Us </strong></h4>
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










