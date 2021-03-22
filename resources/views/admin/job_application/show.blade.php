@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="white-box">
                <div class="row">
                    <h2 class="m-b-0 m-t-0"><b>Job Name</b> : {{$data->name}}</h2>
                    <hr>
                    <h2 class="m-b-0 m-t-0"><b>Job Title</b> : {{$data->job_title}}</h2>
                    <hr>
                    <h2 class="m-b-0 m-t-0"><b>Company</b> : {{$data->company}}</h2>
                    <hr>
                    <h2 class="m-b-0 m-t-0"><b>Phone</b> : {{$data->phone}}</h2>
                    <hr>
                    <h2 class="m-b-0 m-t-0"><b>Email</b> : {{$data->email}}</h2>
                    <hr>
                    <h2 class="m-b-0 m-t-0"><b>Subject</b> : {{$data->subject}}</h2>
                    <hr>
                    <h2 class="m-b-0 m-t-0"><b>Message</b> : {{$data->message}}</h2>
                    <hr>

                    <h4>
                        Created at`
                        <span class="text-success" style="margin-left: 15px; font-size: 15px">{{$data->created_at}}</span>
                    </h4>
                    <hr>
                </div>
            </div>
        </div>
    </div>
@endsection










