@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">{{$title}}</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <form method="post" action="{{ $route }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="title">Name<strong class="text-danger"> &#42; </strong> </label>
                                @error('title')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="title"
                                       placeholder="Name" name="name" value="{{old('Name')}}" required>
                            </div>

                            <div class="form-group">
                                <label for="link">Surname <strong class="text-danger"> &#42; </strong> </label>
                                @error('link')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="link"
                                       placeholder="Surname" name="surname" value="{{old('surname')}}" required>
                            </div>
                            <div class="form-group">
                                <label for="link">Position <strong class="text-danger"> &#42; </strong> </label>
                                @error('link')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="link"
                                       placeholder="Position" name="position" value="{{old('position')}}" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Description <strong class="text-danger">
                                        &#42; </strong></label>
                                @error('description')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <textarea name="description" id="description" cols="30" rows="10" class="form-control"
                                          style="resize: none;" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="logo">Upload Image <strong class="text-danger"> &#42; </strong></label>
                                @error('path')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="file" id="path" name="path" required class="dropify"/>
                            </div>

                            <button type="submit" class="btn btn-success waves-effect waves-light col-md-12">Save {{$title}}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer')
    <script>
        $(document).ready(function () {
            $("#telephone_number").on('input', function () {
                regex = /^([0-9\s\-\+\(\)]*)$/;
                if (!$(this).val().match(regex)) {
                    $('.phone_err').empty().append(`<strong>Please enter correct telephone number.</strong>`).show();
                }
                else{
                    $('.phone_err').empty().hide();
                }
            })
        })
    </script>
@endpush


