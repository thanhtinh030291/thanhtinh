<!-- Stored in resources/views/layouts/admin/partials/top_bar_navigation.blade.php -->
@extends('layouts.admin.master')
@section('title', __('message.claim_create'))
@section('stylesheets')
   
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
                {{ Form::open(array('files' => true,'url' => 'admin/annotate', 'method' => 'post' ,'class'=>'form-horizontal')) }}
                <!-- Create tour -->
                <!-- Add file image -->
                <div class="row">
                    <div class="col-md-6">
                        <input id="upload" type="file" class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" name="image" value="{{ old('image') }}" required autofocus>
                            @if ($errors->has('image'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                            @endif
                    </div>
                    <div class="col-md-6">
                        <div id="dvExcel">
                        </div>
                    </div>
                </div>
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
@endsection

@section('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>
    
    <script type="text/javascript">
        $("body").on("click", "#upload", function () {
            //Reference the FileUpload element.
            var fileUpload = $("#fileUpload")[0];

            //Validate whether File is valid Excel file.
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
            if (regex.test(fileUpload.value.toLowerCase())) {
                if (typeof (FileReader) != "undefined") {
                    var reader = new FileReader();

                    //For Browsers other than IE.
                    if (reader.readAsBinaryString) {
                        reader.onload = function (e) {
                            ProcessExcel(e.target.result);
                        };
                        reader.readAsBinaryString(fileUpload.files[0]);
                    } else {
                        //For IE Browser.
                        reader.onload = function (e) {
                            var data = "";
                            var bytes = new Uint8Array(e.target.result);
                            for (var i = 0; i < bytes.byteLength; i++) {
                                data += String.fromCharCode(bytes[i]);
                            }
                            ProcessExcel(data);
                        };
                        reader.readAsArrayBuffer(fileUpload.files[0]);
                    }
                } else {
                    alert("This browser does not support HTML5.");
                }
            } else {
                alert("Please upload a valid Excel file.");
            }
        });
        function ProcessExcel(data) {
            //Read the Excel File data.
            var workbook = XLSX.read(data, {
                type: 'binary'
            });

            //Fetch the name of First Sheet.
            var firstSheet = workbook.SheetNames[0];

            //Read all rows from First Sheet into an JSON array.
            var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);

            //Create a HTML Table element.
            var table = $("<table />");
            table[0].border = "1";

            //Add the header row.
            var row = $(table[0].insertRow(-1));

            //Add the header cells.
            var headerCell = $("<th />");
            headerCell.html("Id");
            row.append(headerCell);

            var headerCell = $("<th />");
            headerCell.html("Name");
            row.append(headerCell);

            var headerCell = $("<th />");
            headerCell.html("Country");
            row.append(headerCell);

            //Add the data rows from Excel file.
            for (var i = 0; i < excelRows.length; i++) {
                //Add the data row.
                var row = $(table[0].insertRow(-1));

                //Add the data cells.
                var cell = $("<td />");
                cell.html(excelRows[i].Id);
                row.append(cell);

                cell = $("<td />");
                cell.html(excelRows[i].Name);
                row.append(cell);

                cell = $("<td />");
                cell.html(excelRows[i].Country);
                row.append(cell);
            }

            var dvExcel = $("#dvExcel");
            dvExcel.html("");
            dvExcel.append(table);
        };
    </script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
@endsection
