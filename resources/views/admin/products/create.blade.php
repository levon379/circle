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
                                <label for="title">Title<strong class="text-danger"> &#42; </strong> </label>
                                @error('title')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="title"
                                       placeholder="Title" name="title" value="{{old('title')}}" required>
                            </div>

                            <div class="form-group">
                                <label for="product_desc">Product Description<strong class="text-danger"> &#42; </strong> </label>
                                @error('product_desc')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <textarea name="product_desc" id="product_desc" cols="30" rows="10" class="form-control" style="resize: none">{{old('product_desc')}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="uses_desc">Uses Description<strong class="text-danger"> &#42; </strong> </label>
                                @error('uses_desc')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <textarea name="uses_desc" id="uses_desc" cols="30" rows="10" class="form-control" style="resize: none">{{old('product_desc')}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="thumbnail">Thumbnail<strong class="text-danger"> &#42; </strong> </label>
                                @error('thumbnail')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="file" class="form-control dropify" id="thumbnail"
                                       placeholder="thumbnail" name="thumbnail" required>
                            </div>

                            <div class="form-group">
                                <label for="images">Images<strong class="text-danger"> &#42; </strong> </label>
                                @error('images')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="file" class="form-control" id="images"
                                       placeholder="Images" name="images[]" multiple required>
                            </div>

                            <div class="form-group">
                                <label for="category">Category<strong class="text-danger"> &#42; </strong> </label>
                                @error('category')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <select name="category_id" id="category_id" class="form-control">
                                    @foreach($category as $key)
                                        <option value="{{$key->id}}" @if(old('category_id') == $key->id) selected @endif>{{$key->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="show">Show<strong class="text-danger"> &#42; </strong> </label>
                                @error('show')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <select name="show" id="show" class="form-control">
                                    <option value="0" @if(old('show') == 0) selected @endif>Don`t Show</option>
                                    <option value="1" @if(old('show') == 1) selected @endif>Show</option>
                                </select>
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

@push('header')
    <!-- Dropify plugins css -->
    <link rel="stylesheet" href="{{asset('assets/plugins/dropify/dist/css/dropify.min.css')}}">
    <!-- jQuery file upload -->
    <script src="{{asset('assets/plugins/dropify/dist/js/dropify.min.js')}}"></script>
@endpush

@push('footer')
    <script>
        $('.dropify').dropify();
    </script>
@endpush
