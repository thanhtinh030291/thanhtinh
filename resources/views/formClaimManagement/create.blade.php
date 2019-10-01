<!-- Stored in resources/views/layouts/admin/partials/top_bar_navigation.blade.php -->
@extends('layouts.admin.master')
@section('title', __('message.claim_create'))
@section('stylesheets')
    <link href="{{asset('css/fileinput.css')}}" media="all" rel="stylesheet" type="text/css"/>
    <style>
        thead, tbody { display: block; }
        html {
    font-family: Lato, 'Helvetica Neue', Arial, Helvetica, sans-serif;
    font-size: 14px;
}

.table {
    border: none;
}

.table-definition thead th:first-child {
    pointer-events: none;
    background: white;
    border: none;
}

.table td {
    vertical-align: middle;
}

.page-item > * {
    border: none;
}

.custom-checkbox {
    min-height: 1rem;
    padding-left: 0;
    margin-right: 0;
    cursor: pointer; 
}
.custom-checkbox .custom-control-indicator {
    content: "";
    display: inline-block;
    position: relative;
    width: 30px;
    height: 10px;
    background-color: #818181;
    border-radius: 15px;
    margin-right: 10px;
    -webkit-transition: background .3s ease;
    transition: background .3s ease;
    vertical-align: middle;
    margin: 0 16px;
    box-shadow: none; 
}
    .custom-checkbox .custom-control-indicator:after {
        content: "";
        position: absolute;
        display: inline-block;
        width: 18px;
        height: 18px;
        background-color: #f1f1f1;
        border-radius: 21px;
        box-shadow: 0 1px 3px 1px rgba(0, 0, 0, 0.4);
        left: -2px;
        top: -4px;
        -webkit-transition: left .3s ease, background .3s ease, box-shadow .1s ease;
        transition: left .3s ease, background .3s ease, box-shadow .1s ease; 
    }
.custom-checkbox .custom-control-input:checked ~ .custom-control-indicator {
    background-color: #84c7c1;
    background-image: none;
    box-shadow: none !important; 
}
.custom-checkbox .custom-control-input:checked ~ .custom-control-indicator:after {
    background-color: #84c7c1;
    left: 15px; 
}
.custom-checkbox .custom-control-input:focus ~ .custom-control-indicator {
    box-shadow: none !important; 
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
                    <div class="col-md-8">
                        <input id="fileUpload" type="file" class="file" name="file" value="{{ old('file') }}"  autofocus>
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
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
    </div>
    <div class="modal-body">
        <p>Some text in the modal.</p>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
    <script src="{{asset('js/fileinput.js')}}"></script>
    <script src="{{asset('js/papaparse.min.js')}}"></script>
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
                                    .append($('<input type="checkbox" class="custom-control-input" checked name = "checkbox[]" value = "1">'))
                                    .append($('<span class="custom-control-indicator"></span>'))
                            )
                        )
                        .append($('<button type="button" class=" col-md-3 btn btn-primary p-0 btnConfirm"  data-toggle="modal" data-target="#confirmModal" title="Delete this row in the table!" style = "display: block" ><i class="fa fa-comments" aria-hidden="true"></i></button>'))
                        
                    );
                    
                }
                $(rowData).each(function (j, cellData) {
                    if(i != 0){
                        row.append($('<td><input name = "row['+i+'][]" value = "'+cellData+'" /></td>'));
                    }else{
                        row.append($('<th>'+cellData+'</th>'));
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
            console.log("    Results:", results);
            $('#dvExcel').append(arrayToTable(results.data));
        }
    </script>

    <script>
        $(document).on("click", ".delete_row_btn", function(){
            $(this).closest('tr').remove();
        });
    </script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
            $('.btnConfirm').on('click', function () {
                $(this).tooltip('hide');
                $("#confirmModal").modal();
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
