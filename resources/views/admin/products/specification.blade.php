@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">{{$title}}</h3>

                {{--table--}}
                <div class="table-responsive">
                    <table id="datatable" class="display table table-striped table-bordered" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr>
                            <th>Options</th>
                            <th>Specification
                            @foreach($type as $key)
                                <th class="text-capitalize">{{$key->name}}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($specification as $key=>$val)
                            <tr>
                                <td class="option">
                                    <button type="button" class="btn btn-info plus" data-toggle="modal"
                                            data-target="#modal">+
                                    </button>
                                </td>
                                <td data-name="{{$val->name}}" data-id="{{$val->id}}"
                                    class="specification">{{$val->name}}</td>

                                @foreach($type as $t)
                                    <td>
                                        <ul>
                                            @foreach($data as $b=>$v)
                                                @if($v->specification_id == $val->id AND $v->type_id == $t->id)
                                                    <li>
                                                        <button type="button" data-id="{{$v->id}}"
                                                                class="btn btn-danger btn-circle ajax-delete"><i
                                                                class="fas fa-trash"></i></button>
                                                        <b class="edit" data-id="{{$v->id}}">{{$v->name}}</b>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </td>
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
        table {
            table-layout: fixed;
        }

        ul {
            margin: 0;
            padding: 0;
        }

        li {
            list-style: none;
            margin-bottom: 10px;
        }

        b {
            cursor: alias;
        }

        .form-group input {
            width: 90%;
            display: inline-block;
        }

        .option {
            text-align: center;
            vertical-align: middle !important;
        }

        .specification {
            vertical-align: middle !important;
            font-size: 16px;
            font-weight: bolder;
            color: #000000;
        }
    </style>
@endpush

@push('footer')
    <script src="{{asset('assets/plugins/swal/sweetalert.min.js')}}"></script>

    <script !src="">
        $(document).ready(function () {
            let row = 0;

            $('.plus').click(function () {
                let specification_name = $(this).closest("tr").find('td:eq(1)').data('name');
                let specification_id = $(this).closest("tr").find('td:eq(1)').data('id');

                let type = '<?php echo $type; ?>';
                type = JSON.parse(type);
                let type_elem = "";

                for (let i = 0; type.length > i; i++) {
                    type_elem += `
                                <div class="form-group units m-b-20">
                                    <input type="text" name="data[${type[i].id}][]" class="form-control m-b-20" placeholder="${type[i].name}">
                                    <button type="button" class="btn btn-success row-add">+</button>
                                </div>
                                `
                }

                $('.title').empty()
                $('.title').html(specification_name)

                $('.spec-form').empty();
                $('.spec-form').append(`
                    <input type="hidden" name="specification_id" value="${specification_id}">
                    ${type_elem}
                    <button type="submit" class="btn btn-primary col-md-12">Save</button>
                `);
            });

            $(document).on('click', '.row-add', function () {
                let elem_name = $(this).parent().find('input').attr('name');
                let elem_placeholder = $(this).parent().find('input').attr('placeholder');
                let parent = $(this).parent()

                parent.append(`
                    <input type="text" name="${elem_name}" class="form-control m-b-20"  data-row="${row}" placeholder="${elem_placeholder}" required>
                    <button type="button" class="btn btn-danger row-remove" data-row="${row}">-</button>
                `);
                row++;
            });

            $(document).on('click', '.row-remove', function () {
                btn_row = $(this).data('row');
                input_row = $(this).parent().find('input')
                input_row.each((index, item) => {
                    if ($(item).length > 0 && $(item).data('row') === btn_row) {
                        $(item).remove();
                        $(this).remove();
                    }
                });
                row--;
            });

            $(document).on('click', '.edit', function () {
                let element = $(this);
                let id = $(this).data('id');
                let input = $(`<input class="ajax-edit" data-id="${id}"/>`).val(element.text());
                element.replaceWith(input);

                let save = function () {
                    if (input.val() == "" || input.val() == 0) {
                        var $b = $(`<b class="edit" data-id="${id}"><b/>`).text(element.text());
                    } else {
                        var $b = $(`<b class="edit" data-id="${id}"><b/>`).text(input.val());
                    }
                    input.replaceWith($b);
                };
                input.one('blur', save).focus();
            });

            $(document).on('input', '.ajax-edit', function () {
                let id = $(this).data('id');
                let input = $(this).val();
                let _this = $(this);

                if (input.length != 0 || input != '') {
                    $.ajax({
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        },
                        url: '{{ url('/admin/products/ajax-edit') }}',
                        data: {id, input},
                        success: function (res) {
                            _this.one('blur', function () {
                                let $b = $(`<b class="edit" data-id="${res.id}"><b/>`).text(res.name);
                                _this.replaceWith($b);
                            }).focus();
                        }
                    });
                }
            });

            $(document).on('click', '.ajax-delete', function () {
                let id = $(this).data('id');
                let _this = $(this);

                if (typeof id !== 'undefined') {
                    $.ajax({
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        },
                        url: '{{ url('/admin/products/ajax-delete') }}',
                        data: {id},
                        success: function (res) {
                            _this.closest('li').remove()
                            swal({
                                icon: 'success',
                                title: "Deleted!",
                                text: res.success,
                                timer: 1000
                            });
                        }
                    });
                }
            })
        })
    </script>
@endpush



