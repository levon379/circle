@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="white-box">
                <div class="">
                    <h2 class="m-b-0 m-t-0"><b>Job Title</b> : {{$data->job_title}}</h2>
                    <hr>
                    <h4>
                        Created at`
                        <span class="text-success" style="margin-left: 15px; font-size: 15px">{{$data->created_at}}</span>
                    </h4>
                    <hr>
                    <h4>
                        Subject`
                        <span class="text-success" style="margin-left: 15px; font-size: 15px">{{$data->subject}}</span>
                    </h4>
                    <div class="row">
                        <div class="col-lg-9 col-md-9 col-sm-6">
                            <h4 class="box-title">
                                Description
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










