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

                            <div class="form-group">
                                <label for="title">Title<strong class="text-danger"> &#42; </strong> </label>
                                @error('title')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="title"
                                       placeholder="Title" name="title" value="{{$data->title}}" required>
                            </div>

                            <div class="form-group">
                                <label for="product_desc">Product Description<strong class="text-danger">
                                        &#42; </strong> </label>
                                @error('product_desc')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <textarea name="product_desc" id="product_desc" cols="30" rows="10" class="form-control"
                                          style="resize: none">{{$data->product_desc}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="uses_desc">Uses Description<strong class="text-danger"> &#42; </strong>
                                </label>
                                @error('uses_desc')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <textarea name="uses_desc" id="uses_desc" cols="30" rows="10" class="form-control"
                                          style="resize: none">{{$data->product_desc}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="images">Images<strong class="text-danger"> &#42; </strong> </label>
                                @error('images')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="file" class="form-control" id="images"
                                       placeholder="Images" name="images[]" multiple >
                            </div>

                            <div class="form-group">
                                <label for="category">Category<strong class="text-danger"> &#42; </strong> </label>
                                @error('category')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <select name="category_id" id="category_id" class="form-control">
                                    @foreach($category as $key)
                                        <option value="{{$key->id}}"
                                                @if($data->category_id == $key->id) selected @endif>{{$key->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="show">Show<strong class="text-danger"> &#42; </strong> </label>
                                @error('show')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <select name="show" id="show" class="form-control">
                                    <option value="0" @if($data->show == 0) selected @endif>Don`t Show</option>
                                    <option value="1" @if($data->show == 1) selected @endif>Show</option>
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

    {{--image part--}}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">Edit {{$title}} Images</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="datatable" class="display table table-hover table-striped nowrap" cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Image</th>
                                    <th>Options</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data->image as $key=>$val)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td><img src="{{ asset("/uploads/".$val->image)}}" class="img-responsive"
                                                 width="200"></td>
                                        <td>

                                            <form style="display: inline-block"
                                                  action="{{ $route."/".$data->id."/destroy-image/".$val->id }}"
                                                  method="post" id="work-for-form">
                                                @csrf
                                                @method("DELETE")
                                                <a href="javascript:void(0);" data-text="{{ $title }} Image"
                                                   class="delForm" data-id="{{$val->id}}">
                                                    <button data-toggle="tooltip"
                                                            data-placement="top" title="Remove"
                                                            class="btn btn-danger btn-circle tooltip-danger"><i
                                                            class="fas fa-trash"></i></button>
                                                </a>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('header')
    <!--This is a datatable style -->
    <link href="{{asset('assets/plugins/datatables/media/css/dataTables.bootstrap.css')}}" rel="stylesheet"
          type="text/css"/>
@endpush

@push('footer')
    <!--Datatable js-->
    <script src="{{asset('assets/plugins/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('assets/plugins/swal/sweetalert.min.js')}}"></script>
@endpush

