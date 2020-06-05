@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">{{$title}}</h3>

                {{--table--}}
                <div class="table-responsive">
                    <table id="datatable" class="display table borderless" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr>
                            <th>Options</th>
                            <th>Specification</th>
                            <th>Units</th>
                            <th>Value</th>
                            <th>Tolerance</th>
                            <th>Method</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($specification as $key=>$val)
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-info plus" data-toggle="modal" data-target="#modal" >+</button>
                                </td>
                                <td data-name="{{$val->name}}" data-id="{{$val->id}}">{{$val->name}}</td>

                                @foreach($data as $k=>$v)
                                    @if($v->specification_id == $val->id)
                                        <td>
                                            @foreach(json_decode($data[$k]->units) as $u)
                                                <strong>{{$u}}</strong> <br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach(json_decode($data[$k]->value) as $u)
                                                    <strong>{{$u}}</strong> <br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach(json_decode($data[$k]->tolerance) as $u)
                                                <strong>{{$u}}</strong> <br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach(json_decode($data[$k]->method) as $u)
                                                <strong>{{$u}}</strong> <br>
                                            @endforeach
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="modalLabel"><span class="title">10</span>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </h2>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ $route."/".$id."/specification" }}" enctype="multipart/form-data">
                        @csrf
                        <div class="container-fluid">
                            <div class="row spec-form">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('header')
    <style>
        .form-group input{
            width: 90%;
            display: inline-block;
        }
        .borderless td, .borderless th {
            border: none !important;
        }
    </style>
@endpush

@push('footer')
    <script !src="">
        $(document).ready(function () {
            let row = 0;

            $('.plus').click(function () {
                let specification_name = $(this).closest("tr").find('td:eq(1)').data('name');
                let specification_id = $(this).closest("tr").find('td:eq(1)').data('id');

                $('.title').empty()
                $('.title').html(specification_name)

                $('.spec-form').empty();
                $('.spec-form').append(`
                    <input type="hidden" name="specification_id" value="${specification_id}">

                    <div class="form-group units m-b-20">
                        <input type="text" name="units[]" class="form-control m-b-20" placeholder="Units" required>
                        <button type="button" class="btn btn-success row-add">+</button>
                    </div>

                    <div class="form-group value m-b-20">
                        <input type="text" name="value[]" class="form-control m-b-20" placeholder="Value" required>
                        <button type="button" class="btn btn-success row-add">+</button>
                    </div>

                    <div class="form-group tolerance m-b-20">
                        <input type="text" name="tolerance[]" class="form-control m-b-20" placeholder="Tolerance" required>
                        <button type="button" class="btn btn-success row-add">+</button>
                    </div>

                    <div class="form-group method m-b-20">
                        <input type="text" name="method[]" class="form-control m-b-20" placeholder="Method" required>
                        <button type="button" class="btn btn-success row-add">+</button>
                    </div>

                    <button type="submit" class="btn btn-primary col-md-12">Save</button>
                `);
            });

            $(document).on('click','.row-add', function () {
                let elem_name = $(this).parent().find('input').attr('name');
                let elem_placeholder = $(this).parent().find('input').attr('placeholder');
                let parent = $(this).parent()

                parent.append(`
                    <input type="text" name="${elem_name}" class="form-control m-b-20"  data-row="${row}" placeholder="${elem_placeholder}" required>
                    <button type="button" class="btn btn-danger row-remove" data-row="${row}">-</button>
                `);
                row++;
            });

            $(document).on('click','.row-remove', function () {
                btn_row = $(this).data('row');
                input_row = $(this).parent().find('input')
                input_row.each((index, item)  => {
                    if($(item).length > 0 && $(item).data('row') === btn_row){
                        $(item).remove();
                        $(this).remove();
                    }
                });
                row--;
            });

        })
    </script>
@endpush



