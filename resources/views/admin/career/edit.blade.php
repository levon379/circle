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
                                <label for="thumbnail">Main Image<strong class="text-danger"> &#42; </strong> </label>
                                @error('thumbnail')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="file" name="thumbnail" class="form-control dropify" id="thumbnail"
                                       placeholder="thumbnail"  data-default-file='{{asset("uploads/$data->logo")}}'>
                            </div>
                            <div class="form-group">
                                <label for="category">Vacancy</label>
                                @error('category')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <select name="vacancy_id" id="vacancy_id" class="form-control">
                                    <option value="0" @if($data->vacancy_id == 0) selected @endif>Choose</option>
                                    @foreach($vacancy as $key)
                                        <option value="{{$key->id}}"
                                                @if($data->vacancy_id == $key->id) selected @endif>{{$key->title}}
                                        </option>
                                    @endforeach
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

@endsection

@push('header')
    <!--This is a datatable style -->
    <link href="{{asset('assets/plugins/datatables/media/css/dataTables.bootstrap.css')}}" rel="stylesheet"
          type="text/css"/>

    <!-- Dropify plugins css -->
    <link rel="stylesheet" href="{{asset('assets/plugins/dropify/dist/css/dropify.min.css')}}">
    <!-- jQuery file upload -->
    <script src="{{asset('assets/plugins/dropify/dist/js/dropify.min.js')}}"></script>
@endpush

@push('footer')

    <script>
        $('.dropify').dropify();
        $('#datatable').DataTable();
        $("#price").on("keypress keyup blur",function (event) {
            //this.value = this.value.replace(/[^0-9\.]/g,'');
            $(this).val($(this).val().replace(/[^0-9\.]/g,''));
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
    </script>
@endpush
