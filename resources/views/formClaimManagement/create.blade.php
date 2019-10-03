<!-- Stored in resources/views/layouts/admin/partials/top_bar_navigation.blade.php -->
@extends('layouts.admin.master')
@section('title', __('message.claim_create'))
@section('stylesheets')
    <link href="{{asset('css/fileinput.css')}}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/formclaim.css')}}" media="all" rel="stylesheet" type="text/css"/>
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
                    <div class="col-md-7">
                        <input id="fileUpload" type="file" class="file" name="file" value="{{ old('file') }}"  autofocus>
                    </div>
                    <div class="col-md-5">
                        {{ Form::label('code_claim', __('message.code_claim'), array('class' => 'labelas')) }} <span class="text-danger">*</span>
                        {{ Form::text('code_claim', old('code_claim'), array('class' => 'form-control', 'required')) }} 
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="table-responsive" id="dvExcel" style="max-height:450px" >
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="{{asset('js/formclaim.js')}}"></script>
    <script type="text/javascript">
        $('#fileUpload').fileinput({
            required: true,
            allowedFileExtensions: ['xlsx', "xls", 'csv']
        }).on("filebatchselected", function(event, files) {
            excelToHtml(files);
        });

        function arrayToTable(tableData) {
            var table = $('<table class="table table-bordered"></table>');
            $(tableData).each(function (i, rowData) {
                var row = $('<tr></tr>');
                if(i == 0){
                    row.append('<th>Action</th>')
                }else{
                    row.append($('<td class="row m-0" style = "width : 130px"></td>')
                        .append($('<button type="button" class=" col-md-3 delete_row_btn btn p-0 btn-danger" data-toggle="tooltip" title="Delete this row in the table!" >&#x2613;</button>'))
                        .append($('<div class="col-md-6 p-0"></div>')
                            .append($('<label class="custom-control custom-checkbox"></label>')
                                    .append($('<input type="checkbox" class="custom-control-input reject" data-id = "'+i+'" onchange="clickInject(this)" checked name = "_checkbox[]" value = "1">'))
                                    .append($('<span class="custom-control-indicator"></span>'))
                            )
                        )
                        .append($('<button id="btnConfirm'+i+'" data-id = "'+i+'" type="button" class=" col-md-3 btn btn-primary p-0 btnConfirm"  data-toggle="modal" data-target="#confirmModal" title="please enter reason for rejection!" style = "display: none" ><i class="fa fa-comments" aria-hidden="true"></i></button>'))
                        .append($('<input type="text"  id="reason'+i+'"  name = "_reason[]" style = "display: none" >'))
                    );
                }
                $(rowData).each(function (j, cellData) {
                    if(i != 0){
                        row.append($('<td><input name = "_row['+i+'][]" value = "'+cellData+'" /></td>'));
                    }else{
                        row.append($('<th></th>')
                            .append($('<select name = "_column[]" class="select2 form-control"></select>')
                                .append('<option value="none" selected >---X---</option>')
                                .append('<option value="content" >content</option>')
                                .append('<option value="unit_price">unit price</option>')
                                .append('<option value="quantity">quantity</option>')
                                .append('<option value="amount" >amount</option>')
                            )
                            .append('<p>'+cellData+'</p>')
                        );
                    }
                    
                });
                table.append(row);
            });
            return table;
        }

        
    </script>

    <script type="text/javascript">
        function excelToHtml(file) {
            data = file[0];
            $('#fileUpload').parse({
				config: {
                    delimiter: "",	// auto-detect
                    newline: "",	// auto-detect
                    quoteChar: '"',
                    escapeChar: '"',
                    header: false,
                    transformHeader: undefined,
                    dynamicTyping: false,
                    preview: 0,
                    encoding: "",
                    worker: false,
                    comments: false,
                    step: undefined,
                    complete: completeFn,
                    error: undefined,
                    download: false,
                    downloadRequestHeaders: undefined,
                    skipEmptyLines: false,
                    chunk: undefined,
                    fastMode: undefined,
                    beforeFirstChunk: undefined,
                    withCredentials: undefined,
                    transform: undefined,
                    delimitersToGuess: [',', '\t', '|', ';', Papa.RECORD_SEP, Papa.UNIT_SEP]
                },
				before: function(file, inputElem)
				{
					
				},
				error: function(err, file)
				{
				},
				complete: function()
				{
                    
				}
			});
        };
        function completeFn(results)
        {
            $('#dvExcel').append(arrayToTable(results.data));
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
        });
    </script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
@endsection
