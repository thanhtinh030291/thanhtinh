<!-- Stored in resources/views/layouts/admin/partials/top_bar_navigation.blade.php -->
@extends('layouts.admin.master')
@section('title', __('message.claim_create'))
@section('stylesheets')
   <style>
       thead, tbody { display: block; }
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
                        <input id="fileUpload" type="file" class="form-control" name="file" value="{{ old('file') }}"  autofocus>
                    </div>
                </div>
                
                <div class="row mt-2 ml-2" >
                    <div class="col-md-6 border border-secondary" style="max-height : 400px">
                        <p class="text-danger"> Please select page to scan OCR </p>
                        <table id="filePreview"  class="table">
                            <tbody style=" height: 300px; overflow-y: auto; overflow-x: hidden; display: block;">
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        {{ Form::label('id_claim', __('message.id_claim'), array('class' => 'labelas')) }} <span class="text-danger">*</span>
                        {{ Form::text('id_claim', old('id_claim'), [ 'class' => 'form-control', 'required']) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" id="dvExcel">
                        <table id="file_tbl" class="display table dataTable table_add_new">
                            </thead>
                                <tr>
                                    <th>content</th>
                                    <th>unit</th>
                                    <th>quantity</th>
                                    <th>unit price</th>
                                    <th>unit price of insurance</th>
                                    <th>service payout rate</th>
                                    <th>total amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="empty_season_price" style="display: none;">
                                </tr>
                                
                                <tr id="clone_season_price" style="display: none;">
                                    <td>{{ Form::text('_content', null, ['class' => 'form-control']) }}</td>
                                    <td style="width : 10%">{{ Form::text('_unit', null, ['class' => 'form-control']) }}</td>
                                    <td style="width : 10%">{{ Form::text('_quantity', null, ['class' => 'form-control']) }}</td>
                                    <td style="width : 10%">{{ Form::text('_unitPrice', null, ['class' => 'form-control']) }}</td>
                                    <td style="width : 10%">{{ Form::text('_unitPriceOfInsurance', null, ['class' => 'form-control']) }}</td>
                                    <td style="width : 10%">{{ Form::text('_servicePayoutRate', null, ['class' => 'form-control']) }}</td>
                                    <td style="width : 15%">
                                        <div class="row">
                                            <div class="col-md-9">
                                                {{ Form::text('_totalAmount', null, ['class' => 'form-control']) }}
                                            </div>
                                            <div class="col-md-3">
                                                <button type="button" class="delete_row_btn p-0">&#x2613;</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
@endsection

@section('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>
    <script src="{{asset('js/tiff.min.js')}}"></script>
    <script type="text/javascript">
        function tinh() {
            $('input[type=radio]').change(function(){
                alert ( $(this).val() );
            
            })
        };

        $(function () {
            Tiff.initialize({TOTAL_MEMORY: 16777216 * 10});
            function show(file) {
                $('#previewFile').empty();
                var reader = new FileReader();
                reader.onload = (function (theFile) {
                    return function (e) {
                        var buffer = e.target.result;
                        var tiff = new Tiff({buffer: buffer});
                        
                        for (var i = 0, len = tiff.countDirectory(); i < len; ++i) {
                        
                            tiff.setDirectory(i);
                            var canvas = tiff.toCanvas();
                            $("#filePreview").find('tbody')
                            .append($('<tr>')
                                .append($('<td>')
                                    .attr('style', 'width:  60%')
                                    .append(canvas)
                                )
                                .append($('<td>')
                                    .append($('<input type="checkbox" name="_page['+i+']" value="'+i+'">'))
                                    .append("<p>Page " +i+ "</p>")
                                )
                            );
                        }
                    }
                })(file);
            reader.readAsArrayBuffer(file);
            
        }
        $('#fileUpload').on('change', function (event) {
            show(event.target.files[0]);
        });
    });
    </script>

    
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
            //console.log(excelRows);

            //Create a HTML Table element.
            var table = $("<table />");
           
            table[0].className = "table";

            //Add the header row.
            var row = $(table[0].insertRow(-1));

            //Add the header cells.
            var nameHead = [ "content", "unit", "quantity", "unit price", "unit price of insurance", "service payout rate", "total amount" ];
            jQuery.each( nameHead, function( i, val ) {
                var headerCell = $("<th />");
                headerCell.html(val);
                row.append(headerCell);
            });
           
            //Add the data rows from Excel file.
            for (var i = 0; i < excelRows.length; i++) {
                //Add the data row.
                var clone =  '<tr id="row-'+i+'">';
                clone +=  $("#clone_season_price").clone().html() + '</tr>';
                clone = clone.replace("_content", "_content["+i+"]");
                clone = clone.replace("_unit", "_unit["+i+"]");
                clone = clone.replace("_quantity", "_quantity["+i+"]");
                clone = clone.replace("_unitPrice", "_unitPrice["+i+"]");
                clone = clone.replace("_unitPriceOfInsurance", "_unitPriceOfInsurance["+i+"]");
                clone = clone.replace("_servicePayoutRate", "_servicePayoutRate["+i+"]");
                clone = clone.replace("_totalAmount", "_totalAmount["+i+"]");
                $("#empty_season_price").before(clone);

                //Add the data row.
                //var row = $(table[0].insertRow(-1));

                //Add the data cells.
                jQuery.each( excelRows[i], function( key, val ) {
                    console.log(val);
                    switch(key) {
                        case 'content':
                            $('input[name="_content['+i+']"]').val(val);
                            break;
                        case 'unit':
                            $('input[name="_unit['+i+']"]').val(val);
                            break;
                        case 'quantity':
                            $('input[name="_quantity['+i+']"]').val(val);
                            break;
                        case "unit price":
                            $('input[name="_unitPrice['+i+']"]').val(val);
                            break;
                        case "unit price of insurance":
                            $('input[name="_unitPriceOfInsurance['+i+']"]').val(val);
                            break;
                        case "service payout rate":
                            $('input[name="_servicePayoutRate['+i+']"]').val(val);
                            break;
                        case "total amount":
                            $('input[name="_totalAmount['+i+']"]').val(val);
                            break;
                        default:
                            break;
                            // code block
                    }
                    // $('input[name="_startDate['+count+']"]').val(startDate);
                    // var cell = $("<td />");
                    // var html = ""
                    // cell.html(excelRows[i][val]);
                    // row.append(cell);
                });
            }
            // var dvExcel = $("#dvExcel");
            // dvExcel.html("");
            // dvExcel.append(table);
        };
    </script>
    <script>
        $(document).on("click", ".delete_row_btn", function(){
             $(this).closest('tr').remove();
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
