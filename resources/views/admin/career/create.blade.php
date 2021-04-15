
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
                                <label for="thumbnail">Main Image<strong class="text-danger"> &#42; </strong> </label>
                                @error('thumbnail')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="file" class="form-control dropify" id="thumbnail"
                                       placeholder="thumbnail" name="thumbnail" required>
                            </div>
                            <div class="form-group">
                                <label for="category">Vacancy</label>
                                @error('category')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <select name="vacancy_id" id="vacancy_id" class="form-control">
                                    <option value="0">Choose</option>
                                    @foreach($vacancy as $key)
                                        <option value="{{$key->id}}" @if(old('vacancy_id') == $key->id) selected @endif>{{$key->title}}</option>
                                    @endforeach
                                </select>
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
        $("#price").on("keypress keyup blur",function (event) {
            //this.value = this.value.replace(/[^0-9\.]/g,'');
            $(this).val($(this).val().replace(/[^0-9\.]/g,''));
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
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
    </script>
@endpush
