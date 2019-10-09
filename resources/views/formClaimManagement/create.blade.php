<!-- Stored in resources/views/layouts/admin/partials/top_bar_navigation.blade.php -->
@php
    
@endphp
@extends('layouts.admin.master')
@section('title', __('message.claim_create'))
@section('stylesheets')
    <link href="{{asset('css/fileinput.css')}}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/formclaim.css')}}" media="all" rel="stylesheet" type="text/css"/>
    <style>
        #page {
            padding: 6px;
            width: 41%;
            min-height:20%;
            max-height: 500px;
            background: aliceblue;
            text-align: center;
            line-height: 34px;
            cursor: move;
            border: 1px solid #d55900;
            position: fixed;
            top: 23%;
            right: 2%;
            z-index: 100;
            overflow-x: hidden; 
            overflow-x: auto;
        }
        .button-preview {
            position: fixed;
            top: 50%;
            right: 5px;
        }

        .resize-checkbox {
            width: 20px;
            height: 20px;
        }
    </style>
@endsection
@section('content')
@include('layouts.admin.breadcrumb_index', [
    'title'       => __('message.claim_create'),
    'parent_url'  => route('form_claim.index'),
    'parent_name' => __('message.claim_management'),
    'page_name'   => __('message.claim_create'),
])

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                {{ Form::open(array('files' => true,'url' => 'admin/form_claim', 'method' => 'post' ,'class'=>'form-horizontal')) }}
                <!-- Add file file -->
                <div class="row">
                    <div class="col-md-3">
                        {{ Form::label('file', 'File ORC', array('class' => 'labelas')) }} <span class="text-danger">*(CSV )</span>
                        {{ Form::file('file', array('id' => "fileUpload", 'class' => "file")) }} 

                        
                    </div>
                    <div class="col-md-3">
                        {{ Form::label('file2', 'File TIFF', array('class' => 'labelas')) }} <span class="text-danger">*(tif , tiff )</span>
                        {{ Form::file('file2', array('id' => "fileUpload2", 'class' => "file")) }} 
                    </div>
                    <div class="col-md-6">
                        {{ Form::label('code_claim', __('message.code_claim'), array('class' => 'labelas')) }} <span class="text-danger">*</span>
                        {{ Form::text('code_claim', old('code_claim'), array('class' => 'form-control', 'required')) }}
                        <div id="page">
                            <div id="list-page"></div>
                            <div id="show-page"></div>
                        </div>
                        <button type="button" class=" btn btn-success button-preview"><i class="fa fa-search-plus" aria-hidden="true"></i></button>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="table-responsive" id="dvExcel" style="max-height:450px" >
                    </div>
                </div>
                <div class="row p-2 mt-3 .bg-light">
                    <div class="form-check col-md-1">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input resize-checkbox" value="" onClick="checkAll(this)" > 
                                <p class="ml-2 mt-2">Check All</p>
                            </label>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div  class='col-md-11'>
                                {{ Form::select('_sel', $listReasonInject, old('_sel'), array( 'id'=>'select-inject-default','class' => 'select2 labelas')) }}
                            </div>
                            <button type="button" onclick="clickGo()" class="btn btn-secondar col-md-1">GO</button>
                        </div>
                    </div>
                </div>
                <!-- Template table -->
                
                <br/>
                <div class="d-flex justify-content-center">
                    <a class="btn btn-secondary btnt" href="{{url('admin/form_claim')}}">
                        {{ __('message.back')}}
                    </a>
                    <button type="submit" class="btn btn-danger center-block btnt ml-3" > {{__('message.save')}}</button>
                </div>
                <!-- End file image -->
                {{ Form::close() }}
                
                
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Reason For Inject</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
                
            {{ Form::select('_selectReason', $listReasonInject, old('_selectReason'), [ 'id' => 'select-reason', 'class' => 'select2 ', 'required', 'placeholder' => __('message.please_select')]) }}
            {{ Form::hidden('_idrow', null , ['id' => 'id_row']) }}
            
        </div>
        <div class="modal-footer">
                <button class="btn btn-danger" id = 'btn-save-comfirm'>{{ __('message.yes')}} </button>
                <button type="button" class="btn btn-secondary btn-cancel-delete" 
                    data-dismiss="modal">{{ __('message.no') }}</button>
        </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{asset('js/fileinput.js')}}"></script>
    <script src="{{asset('js/papaparse.min.js')}}"></script>
    <script src="{{asset('js/popper.min.js')}}" ></script>
    <script src="{{ asset('js/tiff.min.js') }}"></script>
    <script src="{{asset('js/formclaim.js')}}"></script>
    <script src="{{ asset('js/format-price.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script type="text/javascript">
        var trialImage;
        var selectpage = 0;
        $('#fileUpload').fileinput({
            required: true,
            allowedFileExtensions: ['csv']
        }).on("filebatchselected", function(event, files) {
            $( "#dvExcel" ).empty();
            excelToHtml(files);
        });
        $('#fileUpload2').fileinput({
            required: true,
            allowedFileExtensions: ['tiff','tif','TIFF','TIF']
        }).on("filebatchselected", function(event, files) {
            trialImage = files[0];
            showTiff(trialImage);
        });

        function arrayToTable(tableData) {
            var table = $('<table class="table table-primary table-hover"></table>');
            //option select field
            var arrOption = @json(config('constants.field_select'));
            var selectOption = '<select name = "_column[]" class="select2 form-control select_field">';
            selectOption += '<option value="none" selected >---X---</option>';
            $.each(arrOption, function (index, value) {
                selectOption += '<option value="'+index+'" >'+value+'</option>';
            });
            selectOption += '</select>';


            $(tableData).each(function (i, rowData) {
                var row = $('<tr></tr>');
                if(i == 0){
                    row.append('<th>Action</th>')
                }else{
                    row.append($('<td class="row pl-0 pr-0 m-0" style = "width : 170px"></td>')
                        .append($('<input class = "checkbox_class col-md-2 resize-checkbox" type="checkbox"  data-id = "'+i+'" />'))
                        .append($('<button type="button" class=" col-md-3 delete_row_btn btn p-0 btn-danger" data-toggle="tooltip" title="Delete this row in the table!" >&#x2613;</button>'))
                        .append($('<div class="col-md-5 p-0"></div>')
                            .append($('<label class="custom-control custom-checkbox"></label>')
                                    .append($('<input type="checkbox" id = "inputReject'+i+'" class="custom-control-input reject" data-id = "'+i+'" onchange="clickInject(this)" checked name = "_checkbox[]" value = "1">'))
                                    .append($('<span class="custom-control-indicator"></span>'))
                            )
                        )
                        .append($('<button id="btnConfirm'+i+'" data-id = "'+i+'" type="button" class=" col-md-2 btn btn-primary p-0 btnConfirm"  data-toggle="modal" data-target="#confirmModal" title="please enter reason for rejection!" style = "display: none" ><i class="fa fa-comments" aria-hidden="true"></i></button>'))
                        .append($('<input type="text"  id="reason'+i+'"  name = "_reason[]" style = "display: none" >'))
                    );
                }
                $(rowData).each(function (j, cellData) {
                    cellData = cellData  ? cellData : ""; 
                    if(i != 0){
                        row.append($('<td><input class ="form-control" name = "_row['+i+'][]" value = "'+cellData+'" /></td>'));
                    }else{
                        row.append($('<th></th>')
                            .append($(selectOption).attr('id', j))
                            .append($('<input name = "_row['+i+'][]" data-id= "'+j+'" value = "'+cellData+'" class ="p-1 h5 bg-info" readonly />'))
                        );
                    }
                    
                });
                table.append(row);
            });
            return table;
        } 
    </script>


    <script>
        $(document).on("click", ".delete_row_btn", function(){
            $(this).closest('tr').remove();
        });
    </script>
    <script>
        // lick checkbox show buton comfirm
        function clickInject(e){
            var row = e.dataset.id;
            if(!e.checked) {
                $("#btnConfirm"+row).show();
            }else{
                $("#btnConfirm"+row).hide();
            }
        }

        // add value default to modal
        $(document).on("click", ".btnConfirm", function(){
            var id = $(this).data('id');
            $('#id_row').val(id);
        });

        // add value select to row and change tooltip
        $(document).on("click", "#btn-save-comfirm", function(){
            var id = $('#id_row').val();
            var selectText = $( "select#select-reason option:checked" ).text();
            var selectValue = $( "select#select-reason option:checked" ).val();
            $('#reason'+id).val(selectValue);
            $('#btnConfirm'+id).attr('title', selectText)
            $('#confirmModal').modal('hide');
        });

        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip({
                customClass: 'tooltip-custom'
            });

            //add old value
            var old_data = @json(old('_row'));
            if(old_data != null){
                console.log(old_data);
                $('#dvExcel').append(arrayToTable(Object.values(old_data)));
            }
            
        });

        $(document).on("change", ".select_field", function(e){
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            var id = $(this).attr('id');
            var col = parseInt(id) + 2;
            var arrElement = $("tr td:nth-child("+col+") input");
            checkValueCol(valueSelected, arrElement);
        });        
    </script>


    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
        
    <script>
        $( function() {
            $( "#page" ).draggable();
        } );
        $(document).ready(function () {
            $(".button-preview").click(function () {
                $("#page").toggle(1000);
            });
        });
    </script>
@endsection
