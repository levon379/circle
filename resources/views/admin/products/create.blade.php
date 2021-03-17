
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
                                <label for="title">Title<strong class="text-danger"> &#42; </strong> </label>
                                @error('title')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="title"
                                       placeholder="Title" name="title" value="{{old('title')}}" required>
                            </div>





                            <div class="form-group">
                                <label for="thumbnail">Main Image<strong class="text-danger"> &#42; </strong> </label>
                                @error('thumbnail')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="file" class="form-control dropify" id="thumbnail"
                                       placeholder="thumbnail" name="thumbnail" required>
                            </div>


                            <div class="form-group">
                                <label for="category">Category<strong class="text-danger"> &#42; </strong> </label>
                                @error('category')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <select name="category_id" id="category_id" class="form-control">
                                    @foreach($category as $key)
                                        <option value="{{$key->id}}" @if(old('category_id') == $key->id) selected @endif>{{$key->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="show">Show<strong class="text-danger"> &#42; </strong> </label>
                                @error('show')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <select name="show" id="show" class="form-control">
                                    <option value="0" @if(old('show') == 0) selected @endif>Don`t Show</option>
                                    <option value="1" @if(old('show') == 1) selected @endif>Show</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="product_tab">Select Tabs </label>
                                @error('product_tab')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <div class="form-check form-check-inline">
                                    @foreach($product_tabs as $key)
                                        <input type="checkbox" class="form-check-input" name="tabs[]" value="{{$key->id}}" id="{{$key->id}}" autocomplete="off">
                                        <label class="form-check-label" for="btncheck">{{$key->name}}</label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="product_desc">Product Description</label>
                                @error('product_desc')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <textarea name="product_desc" id="product_desc" cols="30" rows="10" class="form-control" style="resize: none">{{old('product_desc')}}</textarea>
                            </div>
                            <div class="">
                                <div id="product-lists-container" class="form-inline">
                                </div>
                            </div>
                            <div style="margin-bottom:10px">
                                <button id="add-list" type="button" class="btn btn-primary" onclick="addList()">Add List</button>
                            </div>
                            <div class="form-group">
                                <label for="uses_desc">Images Description</label>
                                @error('uses_desc')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <textarea name="uses_desc" id="uses_desc" cols="30" rows="10" class="form-control" style="resize: none">{{old('product_desc')}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="images">Images</label>
                                @error('images')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="file" class="form-control" id="images"
                                       placeholder="Images" name="images[]" multiple >
                            </div>

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



@endpush

@push('footer')
    <script>
        $('.dropify').dropify();
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
            const ulHtml =
                '<ul id="product-list-ul-' + currentListIndex + '" data-list-index="' + currentListIndex + '" class="list-group ">' +
                '<li class="list-group-item">' +
                '   <div class="input-group" style="width:70%">' +
                '       <label htmlFor="' + ulInputId + '">List </label>' +
                '       <div class="input-group-append">' +
                '           <input id="' + ulInputId + '" style="width:65%" type="text" name="' + ulInputName + '"  value="' + name + '" class="form-control" placeholder="Name" />' +
                '           <button type="button" class="btn btn-danger waves-effect waves-light form-control" title="Delete list" onclick="removeList(this)">x</button>' +
                '           <button type="button" class="btn btn-secondary waves-effect waves-light form-control" title="Add item" onclick="addItem(this)">Add item</button>' +
                // '       <button id="' + ulInputDesc + '-disable-button" style="' + (showDescription ? "" : "display:none") + '" type="button" class="btn btn-danger waves-effect waves-light form-control" title="Disable description" onclick="disableDescription(\'' + ulInputDesc + '\')">Disable desc</button>' +
                '           <button id="' + ulInputDesc + '-enable-button" style="' + (showDescription ? "display:none" : "") + '" type="button" class="btn btn-secondary waves-effect waves-light form-control" title="Enable description" onclick="enableDescription(\'' + ulInputDesc + '\')">Add desc</button>' +
                '       </div>' +
                '   </div>' +
                '   <div class="input-group-append" style="width:70%">' +
                '       <textarea id="' + ulInputDesc + '" cols="20" style="width:65%;margin-top: 10px;' + (showDescription ? "" : "display:none") +'" name="' + ulInputDesc + '" class="form-control" placeholder="Description">' + description + '</textarea>' +
                '       <button type="button" class="btn btn-danger waves-effect waves-light form-control" id="' + ulInputDesc + '-disable-button"  style="' + (showDescription ? "" : "display:none") +'"  title="Delete Desc" onclick="disableDescription(\'' + ulInputDesc + '\')">x</button>' +
                '   </div>' +
                '</li>' +
                '</ul>'
            $("#product-lists-container").append(ulHtml);
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
                '<li class="list-group-item">' +
                '   <div class="input-group" style="width:70%">' +
                '       <div class="input-group-append">' +
                '       <input class="form-control" style="width:65%" name="' + liInputName + '" value="' + value + '"  placeholder="Item name"/>' +
                '           <button type="button" class="btn btn-primary waves-effect waves-light" onclick="removeItem(this)">x</button>' +
                '       </div>' +
                '   </div>' +
                '</li>'
            );
        }

        function removeList(element) {
            $(element).closest('ul').remove();
        }
        function removeDesc(element) {
            //disableDescription(elementId);
            $(element).closest('div').remove();
        }
        function removeItem(element) {
            $(element).closest('li').remove();
        }
    </script>
@endpush
