<!-- Stored in resources/views/layouts/admin/partials/top_bar_navigation.blade.php -->
@extends('layouts.admin.master')
@section('title', __('message.claim_create'))
@section('stylesheets')
    <link href="{{asset('css/fileinput.css')}}" media="all" rel="stylesheet" type="text/css"/>
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
                        <input id="fileUpload" type="file" class="file" name="file" value="{{ old('file') }}"  autofocus>
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
    
    
    <script src="{{asset('js/fileinput.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/4.1.2/papaparse.js"></script>
    <script type="text/javascript">
        $('#fileUpload').fileinput({
            required: true,
            allowedFileExtensions: ['xlsx', "xls", 'csv']
        }).on("filebatchselected", function(event, files) {
            excelToHtml(file);
        });

        function arrayToTable(tableData) {
            var table = $('<table></table>');
            $(tableData).each(function (i, rowData) {
                var row = $('<tr></tr>');
                $(rowData).each(function (j, cellData) {
                    row.append($('<td>'+cellData+'</td>'));
                });
                table.append(row);
            });
            return table;
        }

        
    </script>
    

    
    <script type="text/javascript">
        function excelToHtml(file) {
            console.log(Papa.parse(file).data);
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
