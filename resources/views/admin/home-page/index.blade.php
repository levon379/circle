@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">

                {{--table--}}
                <div class="table-responsive">
                    <table id="datatable" class="display table table-hover table-striped" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $key=>$val)
                            <tr data-pjax="{{$key + 1}}" data-key="{{$val->id}}">
                                <td>{{$key + 1}}</td>

                                <td>{{$val->type}}</td>

                                <td>
{{--                                    <a href="{{$route."/".$val->id}}" data-toggle="tooltip"--}}
{{--                                       data-placement="top" title="Show"--}}
{{--                                       class="btn btn-warning btn-circle tooltip-warning">--}}
{{--                                        <i class="fas fas fa-eye"></i>--}}
{{--                                    </a>--}}

                                    <a href="{{$route."/".$val->id."/edit"}}" data-toggle="tooltip"
                                       data-placement="top" title="Edit" class="btn btn-info btn-circle tooltip-info">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form style="display: inline-block" action="{{ $route."/".$val->id }}"
                                          method="post" id="work-for-form">
                                        @csrf
                                        @method("DELETE")
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
        $('#datatable').DataTable({"bSort" : false});
    </script>
@endpush



