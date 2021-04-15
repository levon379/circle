@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">{{$title}}</h3>
                <a href="{{$route."/create"}}" class="btn btn-success m-b-30"><i class="fas fa-plus"></i> Add New {{ $title }}</a>

                {{--table--}}
                <div class="table-responsive">
                    <table id="datatable" class="display table table-hover table-striped" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th style="width:110px !important">Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $key=>$val)
                            <tr data-pjax="{{$key + 1}}" data-key="{{$val->id}}">
                                <td>{{$key + 1}}</td>
                                <td>
                                    <img src='{{ asset("uploads/".$val->logo)}}' alt="{{$val->title}}" class="img-responsive" width="200">
                                </td>
                                <td>{{$val->title}}</td>
                                <td>

                                    <a href="{{$route."/".$val->id."/edit"}}" data-toggle="tooltip"
                                       data-placement="top" title="Edit" class="btn btn-info btn-circle tooltip-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form style="display: inline-block" action="{{ $route."/".$val->id."/delete" }}"
                                          method="post" id="work-for-form">
                                        @csrf
                                        @method("POST")
                                        <a href="javascript:void(0);" data-text="{{ $title }}" class="delForm" data-id ="{{$val->id}}">
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
@endsection

@push('header')
    <!--This is a datatable style -->
    <link href="{{asset('assets/plugins/datatables/media/css/dataTables.bootstrap.css')}}" rel="stylesheet"
          type="text/css"/>
@endpush

@push('footer')
    <script>
        $('#datatable').DataTable();
        function updateOrdering() {
            var ordering = {};
            $('#datatable .ui-sortable tr').each(function (i, v) {
                $(this).attr('data-pjax', i);
                ordering[i] = {
                    id: $(this).attr('data-key'),
                    ordering: $(this).attr('data-pjax')
                }
            });
            $.ajax({
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                data: ordering,
                url: '/admin/shop/update-ordering',
                success: function (res) {
                }
            });

        }
        $( function() {
            $("#datatable > tbody").sortable();

            var tbl_product = $("#datatable> tbody");
            tbl_product.sortable({
                items: 'tr:has(td)'
            });
            // tbody.disableSelection();
            tbl_product.sortable({
                stop: function (event, ui) {
                    updateOrdering()
                }
            });

        } );
    </script>
@endpush



