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
                                <label for="factory_name">Factory Name <strong class="text-danger"> &#42; </strong> </label>
                                @error('factory_name')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="factory_name"
                                       placeholder="Factory Name" name="factory_name" value="{{$data->factory_name}}" required>
                            </div>

                            <div class="form-group">
                                <label for="country">Country <strong class="text-danger"> &#42; </strong> </label>
                                @error('country')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="country"
                                       placeholder="Country" name="country" value="{{$data->country}}" required>
                            </div>

                            <div class="form-group">
                                <label for="telephone_number">Telephone Number <strong class="text-danger"> &#42; </strong> </label>
                                @error('telephone_number')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="telephone_number"
                                       placeholder="Telephone Number" name="telephone_number" value="{{$data->telephone_number}}" required>
                            </div>

                            <div class="form-group">
                                <label for="fax_number">Fax Number <strong class="text-danger"> &#42; </strong> </label>
                                @error('fax_number')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="fax_number"
                                       placeholder="Fax Number" name="fax_number" value="{{$data->fax_number}}" required>
                            </div>

                            <div class="form-group">
                                <label for="po_box">P.O Box <strong class="text-danger"> &#42; </strong> </label>
                                @error('po_box')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="po_box"
                                       placeholder="P.O Box" name="po_box" value="{{$data->po_box}}" required>
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
