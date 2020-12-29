@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="white-box">
                <div class="">
                    <h2 class="m-b-0 m-t-0">{{$data->name}}</h2>
                    <hr>
                    <h4>
                        Created at`
                        <span class="text-success" style="margin-left: 15px; font-size: 15px">{{ date('Y-m-d',strtotime($data->created_at))}}</span>
                    </h4>
                    <hr>
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










