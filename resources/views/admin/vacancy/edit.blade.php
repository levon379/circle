@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">{{$action}} {{$title}}</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <form method="post" action="{{ $route."/".$data->id }}" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")

                            <div class="form-group">
                                <label for="title">Title <strong class="text-danger"> &#42; </strong> </label>
                                @error('title')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="title"
                                       placeholder="Title" name="title" value="{{$data->title}}" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Description <strong class="text-danger"> &#42; </strong> </label>
                                @error('description')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <textarea name="description" id="description" cols="30" rows="10" class="form-control"
                                          style="resize: none;" required>{{$data->description}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="location">Location <strong class="text-danger"> &#42; </strong> </label>
                                @error('location')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="location"
                                       placeholder="Location" name="location" value="{{$data->location}}" required>
                            </div>

                            <div class="form-group">
                                <label for="start">Start Date<strong class="text-danger"> &#42; </strong> </label>
                                @error('start')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="start"
                                       placeholder="Start Date" name="start" value="{{$data->start}}" required autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="end">End Date<strong class="text-danger"> &#42; </strong> </label>
                                @error('end')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="end"
                                       placeholder="End Date" name="end" value="{{$data->end}}" required autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="status">Status<strong class="text-danger"> &#42; </strong> </label>
                                @error('status')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <select name="status" id="status" class="form-control" required>
                                    <option value="1" @if($data->status == 1) selected @endif>Active</option>
                                    <option value="0" @if($data->status == 0) selected @endif>Inactive</option>
                                </select>
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


@push('header')
    <!-- Date picker plugins css -->
    <link href="{{asset('assets/plugins/datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Date Picker Plugin JavaScript -->
    <script src="{{asset('assets/plugins/datepicker/bootstrap-datepicker.min.js')}}"></script>
@endpush

@push('footer')
    <script>
        $('#start').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd',
        });

        $('#end').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd',
        });
    </script>
@endpush
