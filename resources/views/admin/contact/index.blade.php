@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-lg-12">

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{$title}}

                        @if(!$data)
                            <a href="{{$route."/create"}}" class="btn btn-instagram text-center"><i class="fas fa-plus"></i> Add Data</a>
                        @else
                            <a href="{{$route."/".$data->id."/edit"}}" class="btn btn-primary text-center"><i class="fas fa-edit"></i> Edit Data</a>
                        @endif
                    </div>

                    <div class="panel-wrapper collapse in">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td align="center"></td>
                                <td class="bold">Factory Name</td>
                                <td>{{$data->factory_name ?? ""}}</td>
                            </tr>

                            <tr>
                                <td align="center"></td>
                                <td class="bold">Country</td>
                                <td>{{$data->country ?? ""}}</td>
                            </tr>

                            <tr>
                                <td align="center"></td>
                                <td class="bold">Telephone Number</td>
                                <td>{{$data->telephone_number ?? ""}}</td>
                            </tr>

                            <tr>
                                <td align="center"></td>
                                <td class="bold">Fax Number</td>
                                <td>{{$data->fax_number ?? ""}}</td>
                            </tr>

                            <tr>
                                <td align="center"></td>
                                <td class="bold">P.O Box</td>
                                <td>{{$data->po_box ?? ""}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('header')
    <style>
        .panel-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .bold{
            font-weight: bold;
        }
    </style>
@endpush






