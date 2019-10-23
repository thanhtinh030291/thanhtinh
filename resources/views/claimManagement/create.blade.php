
@extends('layouts.admin.master')
@section('title', __('message.claim_create'))
@section('stylesheets')
    <link href="{{asset('css/fileinput.css')}}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/formclaim.css')}}" media="all" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
@include('layouts.admin.breadcrumb_index', [
    'title'       => __('message.claim_create'),
    'parent_url'  => route('claim.index'),
    'parent_name' => __('message.claim_management'),
    'page_name'   => __('message.claim_create'),
])

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                {{ Form::open(array('files' => true,'url' => 'admin/claim', 'method' => 'post' ,'class'=>'form-horizontal')) }}
                <!-- Add file file -->
                <div class="row">
                    <div class="col-md-3">
                        {{ Form::label('file', 'File ORC', array('class' => 'labelas')) }} <span class="text-danger">*(CSV )</span>
                        {{ Form::file('file', array('id' => "fileUpload", 'class' => "file")) }} 
                        <button type="button" class="btn btn-danger mt-2 float-right" onclick="btnScan()" ><i class="fa fa-print" aria-hidden="true"></i> Scan</button>
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
                    <div class="col-md-4">
                        <div class="row d-flex justify-content-end">
                            <button type="button" onclick="totalAmount()" class="btn btn-secondar col-md-3">Total Amount</button>
                            <p id="totalAmount" class="col-md-4 bg-danger p-2 m-0 font-weight-bold text-white"></p>
                        </div>
                    </div>
                </div>
                <!-- add new table -->
                <div class="row mt-5">
                    <div class="col-sm-2 col-form-label ">
                        {{ Form::label('new_items_reject', __('message.new_items_reject'), array('class' => 'card-title')) }}
                    </div>
                    <div class="col-sm-9">
                        <button type="button" class="btn btn-secondary mt-2 btnt" onclick="addInputItem()">{{ __('message.add')}}</button>
                    </div> 
                </div>
                <div class="row ">
                    <div class="card table-responsive col-md-9"  style="max-height:450px">
                        <table id="season_price_tbl" class="table table-striped header-fixed">
                            <thead>
                                <tr>
                                    <th>{{ __('message.content')}}</th>
                                    <th>{{ __('message.amount')}}</th>
                                    <th>{{ __('message.reason_reject')}}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="empty_item" style="display: none;">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr id="clone_item" style="display: none">
                                    <td>{{ Form::text('_content_default', null, ['class' => 'form-control', 'onkeydown'=>'search2(this)' ]) }}</td>
                                    <td style="width:180px">
                                        {{ Form::text('_amount_default', null, ['class' => 'item-price form-control']) }}
                                    </td>
                                    <td style="width:480px">
                                        <div style="width:480px">
                                            {{ Form::select('_reasonInject_default', $listReasonInject,null, ['class' => ' form-control ' ,'placeholder' => 'Not Reject']) }}
                                        </div>
                                    </td>
                                    <td style="width:80px">
                                        <button type="button"class="delete_btn btn btn-danger  p-0">&#x2613;</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card col-md-3">
                        <div class="card-body"> 
                            <h5 class="card-title">Suggestions </h5>
                            <div id="result_suggestions">

                            </div>
                        </div>
                    </div>
                </div>
                <!-- end add new table -->
                <br/>
                <div class="d-flex justify-content-center">
                    <a class="btn btn-secondary btnt" href="{{url('admin/claim')}}">
                        {{ __('message.back')}}
                    </a>
                    <button type="submit" class="btn btn-danger center-block btnt ml-3" > {{__('message.save')}}</button>
                </div>
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
                
            {{ Form::select('_selectReason', $listReasonInject, old('_selectReason'), [ 'id' => 'select-reason', 'class' => 'select2', 'required', 'placeholder' => __('message.please_select')]) }}
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
    <script src="{{ asset('js/clipboard.js') }}"></script>
    <script type="text/javascript">
        function arrayToTable(tableData) {
            var table = $('<table class="table table-primary table-hover"></table>');
            //option select field
            var arrOption = @json(config('constants.field_select'));
            var selectOption = '<select name = "_column[]" class="select2 form-control select_field">';
            selectOption += '<option value="" selected >---X---</option>';
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
                                    .append($('<input type="checkbox" id = "inputReject'+i+'" class="custom-control-input reject" data-id = "'+i+'" onchange="clickInject(this)" checked name = "_checkbox['+i+']" value = "1">'))
                                    .append($('<span class="custom-control-indicator"></span>'))
                            )
                        )
                        .append($('<button id="btnConfirm'+i+'" data-id = "'+i+'" type="button" class=" col-md-2 btn btn-primary p-0 btnConfirm"  data-toggle="modal" data-target="#confirmModal" title="please enter reason for rejection!"  data-popover="popover" data-content="none" style = "display: none" ><i class="fa fa-comments" aria-hidden="true"></i></button>'))
                        .append($('<input type="hidden"  id="reason'+i+'"  name = "_reason['+i+']"  >'))
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
        // add value select to row and change tooltip
        $(document).on("click", "#btn-save-comfirm", function(){
            var id = $('#id_row').val();
            var selectText = $( "select#select-reason option:checked" ).text();
            var selectValue = $( "select#select-reason option:checked" ).val();
            $('#reason'+id).val(selectValue);
            $('#btnConfirm'+id).attr('title', selectText);
            $('#confirmModal').modal('hide');
        });

        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip({
                customClass: 'tooltip-custom'
            });

            $('[data-popover="popover"]').popover('show');

            //add old value
            var old_data_row = @json(old('_row'));
            if(old_data_row != null){
                $('#dvExcel').append(arrayToTable(Object.values(old_data_row)));
            }
            var old_data_column = @json(old('_column'));
            if(old_data_row != null){
                $.each(old_data_column, function (index, value) {
                    $('#'+index).val(value).change();
                });
            }
            var old_data_checkbox = @json(old('_checkbox'));
            if(old_data_checkbox != null){
                //mapping checkbox
                    var change_data_checkbox = [] ; 
                $.each(old_data_row, function (index, value) {
                    change_data_checkbox.push(old_data_checkbox[index] ? old_data_checkbox[index] : 0);
                });
                //end
                $(".reject").prop('checked', false);
                $.each(change_data_checkbox, function (index, value) {
                    $('#inputReject'+index).prop('checked', value);
                });
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
    // old 
    <script>
        $(document).on('ready', function() {
            var content = @json(old('_content'));
            var amount = @json(old('_amount'));
            var reasonInject = @json(old('_reasonInject'));
            if(content != null){
                $.each(content, function (index, value) {
                    addInputItem();
                    addValueItem(content[index],amount[index],reasonInject[index],count-1);
                });
            }
        });
    </script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var clipboard = new ClipboardJS('.btn');
        clipboard.on('success', function(e) {
            if(idPaste){
                $("#_content"+idPaste).val(e.text);
                removeIdPaste();
            }
            else{
                alert('Please select the region to paste');
            }
        });

    </script>
@endsection
