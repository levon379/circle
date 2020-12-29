@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="white-box">
                <div class="">
                    <h2 class="m-b-0 m-t-0">{{$data->title}}
                        @if($data->status == 1)
                            <span class="text-uppercase text-success font-12">active</span>
                        @else
                            <span class="text-uppercase text-danger font-12">inactive</span>
                        @endif
                    </h2>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <h4 class="box-title">Description</h4>
                            <p class="col-md-12" style="word-wrap: break-word; white-space: pre-line">{{$data->description}}</p>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <h4 class="box-title">Location and Date</h4>
                            <p class="col-md-12" style="word-wrap: break-word; white-space: pre-line">{{$data->location}}</p>
                            <p class="col-md-12" style="word-wrap: break-word; white-space: pre-line">{{$data->start}} / {{$data->end}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
