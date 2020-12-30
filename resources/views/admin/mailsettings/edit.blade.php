@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">{{$title}}</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <form method="post" action="{{ $route."/".$data->id }}" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")
                            <input type="hidden" value="{{ $data->type }}" name="type">
                            <div class="form-group">
                                <label for="title">Subject <strong class="text-danger"> &#42; </strong> </label>
                                @error('subject')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="subject"
                                       placeholder="Subject" name="subject" value="{{$data->subject}}" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Message <strong class="text-danger">
                                        &#42; </strong></label>
                                @error('message')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <textarea name="message" id="message" cols="30" rows="10" class="form-control"
                                          style="resize: none;" required>{{$data->message}}</textarea>
                            </div>

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
