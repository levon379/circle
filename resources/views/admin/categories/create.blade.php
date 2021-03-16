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
                                <label for="title">Title <strong class="text-danger"> &#42; </strong> </label>
                                @error('name')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="name"
                                       placeholder="Title" name="name" value="{{old('name')}}" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Description <strong class="text-danger"> &#42; </strong></label>
                                @error('description')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <textarea name="description" id="description" cols="30" rows="10" class="form-control"
                                          style="resize: none;" required>{{old('description')}}</textarea>
                            </div>

{{--                            <div class="form-group">--}}
{{--                                <label for="description">Link</label>--}}
{{--                                @error('link')--}}
{{--                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>--}}
{{--                                @enderror--}}
{{--                                <input type="text" name="link" required placeholder="Link" id="link" class="form-control" value="{{old('link')}}">--}}
{{--                            </div>--}}

{{--                             <div class="form-group">--}}
{{--                                <label for="logo">Upload PDF</label>--}}
{{--                                @error('pdf_path')--}}
{{--                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>--}}
{{--                                @enderror--}}
{{--                                <input type="file" id="pdf_path" name="pdf_path" />--}}
{{--                            </div>--}}

{{--                            <div class="form-group">--}}
{{--                                <label for="logo">Upload Image <strong class="text-danger"> &#42; </strong></label>--}}
{{--                                @error('path')--}}
{{--                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>--}}
{{--                                @enderror--}}
{{--                                <input type="file" id="path" name="path" required class="dropify"/>--}}
{{--                            </div>--}}


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

    <!-- Date picker plugins css -->
    <link href="{{asset('assets/plugins/datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Date Picker Plugin JavaScript -->
    <script src="{{asset('assets/plugins/datepicker/bootstrap-datepicker.min.js')}}"></script>

    <style>
        .swal-button--confirm, .swal-button--confirm:hover {
            background-color: green !important;
            color: white;
        }

        .swal-button--cancel, .swal-button--cancel:hover {
            background-color: red !important;
            color: white;
        }
    </style>
@endpush

@push('footer')
    <script src="{{asset('assets/plugins/swal/sweetalert.min.js')}}"></script>
    <script>
        $('.dropify').dropify();

        $('#date').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd',
        }).datepicker("setDate", new Date());

        $(document).ready(function () {
            var i = 1;
            $('#add').click(function () {
                i++;
                if(i <= 5){
                    $('#dynamic_field').append(`<tr id="row${i}">
			            <td>
                            <div class="col-xs-6">
                                <input type="file" name="images[]" class="form-control input-md input_open image"/>
                            </div>

                            <div class="col-xs-6">
                                <input type="file" name="pdf[]" class="form-control input_close pdf"/>
                            </div>
                        </td>
			            <td align="center"><button type="button" name="remove" id="${i}" class="btn btn-danger btn_remove"><i class="fas fa-minus"></i></button></td>
			        </tr>`);
                }
            });

            $(document).on('click', '.btn_remove', function () {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });
        });

        $('.btn-success').on('click', function (e) {
            e.preventDefault();
            let form = $(this).parents('form');
            let bool_image = true;
            let bool_pdf = true;
            let text = '';

            $(".image").each(function (index, item) {
                if($(item).val() === ''){
                    bool_image = false;
                    text = 'Image';
                }
            });
            $(".pdf").each(function (index, item) {
                if($(item).val() === ''){
                    bool_pdf = false;
                    text = 'PDF';
                }
            });

            if(bool_image === false && bool_pdf === false){
                text = 'Pdf and Image';
            }

            if(bool_image === false || bool_pdf === false){
                swal({
                    icon: 'warning',
                    title: "Are you sure?",
                    text: `You want to continue without adding ${text}!`,
                    buttons: {
                        cancel: 'No, cancel it!',
                        confirm: 'Yes, I am sure!',
                    },
                }).then((isConfirm) => {
                    if (isConfirm) form.submit();
                });
            }else{
                form.submit()
            }
        });
    </script>
@endpush
