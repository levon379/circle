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
                                <label for="title">Title<strong class="text-danger"> &#42; </strong> </label>
                                @error('title')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="title"
                                       placeholder="Title" name="title" value="{{$data->title}}" required>
                            </div>



                            <div class="form-group">
                                <label for="thumbnail">Main Image<strong class="text-danger"> &#42; </strong> </label>
                                @error('thumbnail')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="file" class="form-control dropify" id="thumbnail"
                                       placeholder="thumbnail" name="thumbnail" data-default-file='{{asset("uploads/$data->logo")}}'>
                            </div>



                            <div class="form-group">
                                <label for="category">Category<strong class="text-danger"> &#42; </strong> </label>
                                @error('category')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <select name="category_id" id="category_id" class="form-control">
                                    @foreach($category as $key)
                                        <option value="{{$key->id}}"
                                                @if($data->category_id == $key->id) selected @endif>{{$key->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="show">Show<strong class="text-danger"> &#42; </strong> </label>
                                @error('show')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <select name="show" id="show" class="form-control">
                                    <option value="0" @if($data->show == 0) selected @endif>Don`t Show</option>
                                    <option value="1" @if($data->show == 1) selected @endif>Show</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="product_tab">Select Tabs</label>
                                @error('product_tab')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <div class="form-check form-check-inline">
                                    @foreach($tabs as $value)

                                        <input type="checkbox" @if(in_array($value->id,$choosenTabsId)) checked @endif class="form-check-input" name="tabs[]" value="{{$value->id}}" id="{{$value->id}}" autocomplete="off">
                                        <label class="form-check-label" for="btncheck">{{$value->name}}</label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="product_desc">Product Description</label>
                                @error('product_desc')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <textarea name="product_desc" id="product_desc" cols="30" rows="10" class="form-control"
                                          style="resize: none">{{$data->product_desc}}</textarea>
                            </div>
                            <div class="">
                                <div id="product-lists-container" class="form-inline">
                                </div>
                                <input type="hidden" id="product-list-order" name="product-list-order" />
                            </div>
                            <div style="margin-bottom:10px">
                                <button id="add-list" type="button" class="btn btn-primary" onclick="addList()">Add List</button>
                            </div>



                            <div class="form-group">
                                <label for="uses_desc">Images Description</label>
                                @error('uses_desc')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <textarea name="uses_desc" id="uses_desc" cols="30" rows="10" class="form-control"
                                          style="resize: none">{{$data->uses_desc}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="images">Images </label>
                                @error('images')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="file" class="form-control" id="images"
                                       placeholder="Images" name="images[]" multiple >
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
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">Edit {{$title}} Images</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="datatable" class="display table table-hover table-striped nowrap" cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Image</th>
                                    <th>Options</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data->image as $key=>$val)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td><img src="{{ asset("/uploads/".$val->image)}}" class="img-responsive"
                                                 width="200"></td>
                                        <td>

                                            <form style="display: inline-block"
                                                  action="{{ $route."/".$data->id."/destroy-image/".$val->id }}"
                                                  method="post" id="work-for-form">
                                                @csrf
                                                @method("DELETE")
                                                <a href="javascript:void(0);" data-text="{{ $title }} Image"
                                                   class="delForm" data-id="{{$val->id}}">
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
        </div>
    </div>
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
        $("#product-lists-container").sortable({
            items: "ul",
            update: function( ) {
                calculateProductListOrder();
            }
        });
        $('#product-lists-container').disableSelection();

        let currentListIndex = 0;
        const ulListBaseName = "product-list";
        const ulListBaseNameDesc = "product-desc";
        const liItemBaseName = "product-list-item";

        function addList(name, description) {
            if (!name) {
                name = "";
            }
            let showDescription;
            if (!description) {
                description = "";
                showDescription = false;
            } else {
                showDescription = true;
            }

            const ulInputName = ulListBaseName + '-' + currentListIndex;
            const ulInputDesc = ulListBaseNameDesc + '-' + currentListIndex;
            const ulInputId = ulListBaseName + '-' + currentListIndex;
            const ulHiddenInputName = 'ul-order-' + currentListIndex;
            const ulHtml =
                '<ul id="product-list-ul-' + currentListIndex + '" data-list-index="' + currentListIndex + '" class="list-group ui-state-default>' +
                '<li class="list-group-item">' +
                '   <div class="input-group" style="width:70%">' +
                '       <label htmlFor="' + ulInputId + '">' +
                '           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrows-move" viewBox="0 0 16 16">' +
                '               <path fill-rule="evenodd" d="M7.646.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 1.707V5.5a.5.5 0 0 1-1 0V1.707L6.354 2.854a.5.5 0 1 1-.708-.708l2-2zM8 10a.5.5 0 0 1 .5.5v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7.5 14.293V10.5A.5.5 0 0 1 8 10zM.146 8.354a.5.5 0 0 1 0-.708l2-2a.5.5 0 1 1 .708.708L1.707 7.5H5.5a.5.5 0 0 1 0 1H1.707l1.147 1.146a.5.5 0 0 1-.708.708l-2-2zM10 8a.5.5 0 0 1 .5-.5h3.793l-1.147-1.146a.5.5 0 0 1 .708-.708l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L14.293 8.5H10.5A.5.5 0 0 1 10 8z"/>' +
                '           </svg> &nbsp;List' +
                '       </label>' +
                '       <div class="input-group-append">' +
                '           <input id="' + ulInputId + '"  style="width:65%" type="text" name="' + ulInputName + '" value="' + name + '" class="form-control" placeholder="List name" />' +
                '           <button type="button" class="btn btn-danger waves-effect waves-light form-control" title="Delete list" onclick="removeList(this)">x</button>' +
                '       <button type="button" class="btn btn-secondary waves-effect waves-light form-control" title="Add item" onclick="addItem(this)">Add item</button>' +
                // '       <button id="' + ulInputDesc + '-disable-button" style="' + (showDescription ? "" : "display:none") + '" type="button" class="btn btn-danger waves-effect waves-light form-control" title="Disable description" onclick="disableDescription(\'' + ulInputDesc + '\')">Disable desc</button>' +
                '       <button id="' + ulInputDesc + '-enable-button" style="' + (showDescription ? "display:none" : "") + '" type="button" class="btn btn-secondary waves-effect waves-light form-control" title="Enable description" onclick="enableDescription(\'' + ulInputDesc + '\')">Add desc</button>' +
                '       </div>' +
                '   </div>' +
                '   <div class="input-group-append" style="width:70%">' +
                '       <textarea id="' + ulInputDesc + '" cols="20" style="width:65%;margin-top: 10px;' + (showDescription ? "" : "display:none") +'" name="' + ulInputDesc + '" class="form-control" placeholder="Description">' + description + '</textarea>' +
                '       <button type="button" class="btn btn-danger waves-effect waves-light form-control" id="' + ulInputDesc + '-disable-button"  style="' + (showDescription ? "" : "display:none") +'"  title="Delete Desc" onclick="disableDescription(\'' + ulInputDesc + '\')">x</button>' +
                '   </div>' +
                '</li>' +
                '</ul>'
            $("#product-lists-container").append(ulHtml);
            $("#product-lists-container").sortable("refresh");

            $('#product-list-ul-' + currentListIndex).sortable({
                items: "li",
            });
            $('#product-list-ul-' + currentListIndex).disableSelection();

            calculateProductListOrder();

            ++currentListIndex;
        }

        function enableDescription(elementId) {
            $("#" + elementId).show();
            $("#" + elementId + "-disable-button").show();
            $("#" + elementId + "-enable-button").hide();
        }

        function disableDescription(elementId) {
            $("#" + elementId).hide();
            $("#" + elementId + "-disable-button").parent().find( "textarea" ).val('');
            $("#" + elementId + "-disable-button").hide();
            $("#" + elementId + "-enable-button").show();
        }

        function addItem(element, value) {
            if (!value) {
                value = "";
            }
            const currentListSavedIndex = $(element).closest('ul').data("list-index");
            const liInputName = liItemBaseName + '-' + currentListSavedIndex + "[]";
            $(element).closest('ul').append(
                '<li class="list-group-item ui-state-default">' +
                '   <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">' +
                '       <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>' +
                '   </svg>' +
                '   <div class="input-group" style="width:70%">' +
                '       <div class="input-group-append">' +
                '           <textarea class="form-control" style="width:65%"  name="' + liInputName + '"  placeholder="Item name">'+value+'</textarea>' +
                '           <button type="button" class="btn btn-primary waves-effect waves-light" onclick="removeItem(this)">x</button>' +
                '       </div>' +
                '   </div>' +
                '</li>'
            );

            $(element).closest('ul').sortable("refresh");
        }

        function removeList(element) {
            $(element).closest('ul').remove();
        }
        function removeItem(element) {
            $(element).closest('li').remove();
        }

        function calculateProductListOrder() {
            let newOrder = [];
            $("#product-lists-container > ul").each(function () {
                const currentElementIndex = $(this).data("list-index");
                newOrder.push(currentElementIndex);
            });
            $("#product-list-order").val(newOrder.join(','));
        }

        @foreach ($data->product_list as $list)
            addList("{{$list->name}}", "{{$list->description}}");
            @foreach ($list->product_list_items as $item)
                addItem($("#product-list-ul-" + (currentListIndex - 1)), "{{$item->name}}");
            @endforeach
        @endforeach

    </script>
@endpush
