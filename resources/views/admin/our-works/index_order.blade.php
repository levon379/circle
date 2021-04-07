@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">{{$title}}</h3>
                <form action="{{ $route."/update-ordering" }}"
                      method="post" id="work-for-form">
                    @csrf
                    @method("POST")
                    <input type="submit" class="btn btn-success m-b-30" value="Save"/>

                {{--table--}}
                <div class="table-responsive">
                    <table id="datatable" class="display table table-hover table-striped" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th style="width:110px !important">Choose Work</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $key=>$val)
                            <tr data-pjax="{{$key + 1}}" data-key="{{$val->id}}">
                                <td>{{$key + 1}}</td>
                                <td>
                                    <img src='{{ asset("uploads/".$val->logo)}}' alt="{{$val->title}}" class="img-responsive" width="115">
                                </td>
                                <td>{{$val->title}}</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input check_ordering" type="checkbox" value="{{$val->id}}" id="check_ordering" name="order[]">
                                        <label class="form-check-label" for="defaultCheck1">
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                </form>
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
        $( document ).ready(function() {
            $("tbody input[type=checkbox]").click(function() {
                var countchecked = $("tbody input[type=checkbox]:checked").length;

                if (countchecked >= 3) {
                    $('tbody input[type=checkbox]').not(':checked').attr("disabled", true);
                } else {
                    $('tbody input[type=checkbox]').not(':checked').attr("disabled", false);
                }
            });
        });
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
                url: '/admin/our-works/update-ordering',
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
        } );


    </script>
@endpush



