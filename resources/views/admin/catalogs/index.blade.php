@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-lg-12">

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{$title}}

                        @if(!$data)
                            <a href="{{$route."/create"}}" class="btn btn-instagram text-center"><i
                                    class="fas fa-plus"></i> Add File</a>
                        @else
                            <form style="display: inline-block" action="{{ $route."/".$data->id }}"
                                  method="post" id="work-for-form">
                                @csrf
                                @method("DELETE")
                                <a href="javascript:void(0);" data-text="{{ $title }}" class="delForm"
                                   data-id="{{$data->id}}">
                                    <button class="btn btn-danger"><i class="fas fa-trash"></i> Delete File</button>
                                </a>
                            </form>
                        @endif
                    </div>

                    <div class="panel-wrapper collapse in">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td align="center"></td>
                                <td class="bold">Download pdf file</td>
                                @if(isset($data->file))
                                    <td>
                                        <a href='{{asset("uploads/$data->file")}}' class="file" download>Download</a>
                                    </td>
                                @endif
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 pdf"></div>

        </div>
    </div>
@endsection


@push('header')
    <style>
        .pdfobject-container {
            height: 80vh;
        }

        .panel-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .bold {
            font-weight: bold;
        }
    </style>
@endpush

@push('footer')
    <script src="{{asset('assets/plugins/swal/sweetalert.min.js')}}"></script>

    <script src="{{asset('assets/pdfobject/pdfobject.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            let p = $('.file').attr('href');
            if(p){
                PDFObject.embed(p, ".pdf");
            }
        })
    </script>
@endpush








