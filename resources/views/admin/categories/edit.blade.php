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
                                <label for="title">Name <strong class="text-danger"> &#42; </strong> </label>
                                @error('name')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="name"
                                       placeholder="Name" name="name" value="{{$data->name}}" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Description <strong class="text-danger">
                                        &#42; </strong></label>
                                @error('description')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <textarea name="description" id="description" cols="30" rows="10" class="form-control"
                                          style="resize: none;" required>{{$data->description}}</textarea>
                            </div>

{{--                            <div class="form-group">--}}
{{--                                <label for="link">Link</label>--}}
{{--                                @error('link')--}}
{{--                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>--}}
{{--                                @enderror--}}
{{--                                <input type="text" name="link" placeholder="Link" id="link" class="form-control" value="{{$data->link}}">--}}
{{--                            </div>--}}

{{--                            <a href='{{asset("uploads/$data->pdf_path")}}' class="btn btn-info" style="color:white;" download>Download PDF</a>--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="logo">Upload PDF</label>--}}
{{--                                @error('pdf_path')--}}
{{--                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>--}}
{{--                                @enderror--}}
{{--                                <input type="file" id="pdf_path" name="pdf_path" />--}}
{{--                            </div>--}}



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
    <!-- Dropify plugins css -->
    <link rel="stylesheet" href="{{asset('assets/plugins/dropify/dist/css/dropify.min.css')}}">
    <!-- jQuery file upload -->
    <script src="{{asset('assets/plugins/dropify/dist/js/dropify.min.js')}}"></script>

    <!--This is a datatable style -->
    <link href="{{asset('assets/plugins/datatables/media/css/dataTables.bootstrap.css')}}" rel="stylesheet"
          type="text/css"/>
@endpush

@push('footer')

    <script src="{{asset('assets/pdfobject/pdfobject.min.js')}}"></script>
    <script>
        $('.dropify').dropify();

        $('#datatable').DataTable();
         $(document).ready(function () {
            let p = $('.file').attr('href');
            if(p){
                PDFObject.embed(p, ".pdf");
            }
        })
    </script>
@endpush

