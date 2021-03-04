<!-- Stored in resources/views/layouts/admin/partials/top_bar_navigation.blade.php -->
@extends('layouts.admin.master')
@section('title', 'PanciFic-Cross-Admin')
@section('content')
    <style>
        .table td, .table th {
            padding: .2rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
    </style>
    <div class="row">
        <div class="col-xl-12">
            <div class="breadcrumb-holder">
                <h1 class="main-title float-left">Dashboard</h1>
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    
    <div class="row">
            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                    <div class="card-box noradius noborder bg-default">
                            <i class="fa fa-file-text-o float-right text-white"></i>
                            <h6 class="text-white text-uppercase m-b-20">claims</h6>
                            <h1 class="m-b-20 text-white counter">{{$sumClaim}}</h1>
                            <span class="text-white">{{$sumClaimToDate}} New Orders To Date</span>
                    </div>
                    <div class="card-box noradius noborder bg-info">
                        <i class="fa fa-user-o float-right text-white"></i>
                        <h6 class="text-white text-uppercase m-b-20">Users</h6>
                        <h1 class="m-b-20 text-white counter">{{$sumMember}}</h1>
                        <span class="text-white">{{$sumMember}} New Users</span>
                    </div>
            </div>

            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                    <div class="card-box noradius noborder bg-warning">
                            <i class="fa fa-bar-chart float-right text-white"></i>
                            <h6 class="text-white text-uppercase m-b-20">IP Address</h6>
                            <h1 class="m-b-20 text-white counter">{{250}}</h1>
                        <span class="text-white">My IP: {{$Ipclient}}</span>
                    </div>
                    <div class="card-box noradius noborder bg-danger">
                        <i class="fa fa-bell-o float-right text-white"></i>
                        <h6 class="text-white text-uppercase m-b-20">Alerts</h6>
                        <h1 class="m-b-20 text-white counter">58</h1>
                        <span class="text-white">5 New Alerts</span>
                    </div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-6">
                <table class="table table-bordered table-hover display">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($PENDING_LIST as $data2)
                        @php $c = $COUNT_PENDING->where('status', $data2)->count(); @endphp
                        @if($c != 0)
                            <tr>
                                <td>{{data_get(config('constants.status_mantic'), $data2)}}</td>
                                <td>{{$c}}</td>
                            </tr>
                        @endif
                        @endforeach
                        <tr>
                            <th>Total</th>
                            <td>{{$COUNT_PENDING->count()}}</td>
                        </tr>
                        
                    </tbody>
                    </table>
            </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">						
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="text-danger"><i class="fa fa-users"></i> CHƯA GỬI FINANCE THANH TOÁN</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example7" class="table table-bordered table-hover display">
                            <thead>
                                <tr>
                                    <th>LINK ETALK</th>
                                    <th>CA Link</th>
                                    <th>User</th>
                                    <th>UPDATE DATE HBS</th>
                                    <th>UPDATE USER HBS</th>
                                    <th>APP AMT</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($AUDIT_HBS_EXISTED as $data)
                            
                                <tr>
                                    <td>
                                        <a class="btn btn-primary" target="_blank" href="{{config('constants.url_mantic').'view.php?id='.$data->bug_id }}">{{$data->bug_id}}</a>
                                    </td>
                                    <td>
                                        <a href="/admin/claim/barcode/{{$data->bug_id}}" target="_blank">{{ $data->CL_NO }}</a>
                                    </td>

                                    <td>{{$data->handler}}</td>
                                    <td>{{$data->UPD_DATE}}</td>
                                    <td>{{$data->UPD_USER}}</td>
                                    <td class="font-weight-bold text-danger">{{$data->APP_AMT}}</td>
                                </tr>
                            
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>														
            </div><!-- end card-->					
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">						
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="text-danger"><i class="fa fa-users"></i> HBS & FINANCE CÓ SỐ TIỀN KHÁC NHAU</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example6" class="table table-bordered table-hover display">
                            <thead>
                                <tr>
                                    <th>LINK ETALK</th>
                                    <th>CA Link</th>
                                    <th>User</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($AUDIT_DLVN_HBS_CPS_DIFF_AMT as $data)
                            
                                <tr>
                                    <td>
                                        <a class="btn btn-primary" target="_blank" href="{{config('constants.url_mantic').'view.php?id='.$data->bug_id }}">{{$data->bug_id}}</a>
                                    </td>
                                    <td>
                                        <a href="/admin/claim/barcode/{{$data->bug_id}}" target="_blank">{{ $data->CL_NO }}</a>
                                    </td>
                                    <td>{{$data->handler}}</td>
                                </tr>
                            
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>														
            </div><!-- end card-->					
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">						
            <div class="card mb-3">
                <div class="card-header">
                    <h3><i class="fa fa-users"></i> MISSED OR DELAY PAYMENT</h3>
                </div>
                <div class="card-body">
                    
                    <div class="table-responsive">
                        <table id="example2" class="table table-bordered table-hover display">
                            <thead>
                                <tr>
                                    <th>LINK ETALK</th>
                                    <th>CA Link</th>
                                    <th>User</th>
                                    <th>Finish At</th>
                                    <th style="width: 77px !important;">Days Of Delay</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($finishNotPay as $data)
                            
                                <tr>
                                    <td>
                                        <a class="btn btn-primary" target="_blank" href="{{config('constants.url_mantic').'view.php?id='.$data->mantis_id }}">{{$data->mantis_id}}</a>
                                    </td>
                                    <td>
                                        <a href="/admin/claim/{{$data->claim_id}}" target="_blank">{{ $data->cl_no }}</a>
                                    </td>
                                    <td>{{data_get($listUser,$data->user)}}</td>
                                    <td>{{$data->updated_at}}</td>
                                    <td class="font-weight-bold text-danger">{{$data->diff_date}}</td>
                                </tr>
                            
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>														
            </div><!-- end card-->					
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">						
            <div class="card mb-3">
                <div class="card-header">
                    <h3><i class="fa fa-users"></i> PENDING ISSUE</h3>
                </div>
                <div class="card-body">
                    
                    <div class="table-responsive">
                        <table id="example4" class="table table-bordered table-hover display">
                            <thead>
                                <tr>
                                    <th>LINK ETALK</th>
                                    <th>CA Link</th>
                                    <th>Summary</th>
                                    <th>Date Submitted</th>
                                    <th>Last Updated</th>
                                    <th style="width: 77px !important;">Days</th>
                                    <th>Current Status</th>
                                    <th>Reason For Pending</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($MANTIS_BUG as $data)
                            
                                <tr bgcolor={{ data_get($STATUS_COLOR_LIST,$data->status) }}>
                                    <td>
                                        <a class="btn btn-primary" target="_blank" href="{{config('constants.url_mantic').'view.php?id='.$data->id }}">{{$data->id}}</a>
                                    </td>
                                    <td>
                                        <a href="/admin/claim/barcode/{{$data->id}}" target="_blank">{{data_get($data->HBS_DATA,'cl_no')}}</a>
                                    </td>
                                    <td>{{$data->summary}}</td>
                                    <td>{{date("Y-m-d H:i:s",$data->date_submitted)}}</td>
                                    <td>{{date("Y-m-d H:i:s",$data->last_updated)}}</td>
                                    <td style="width: 77px !important;">{{ Carbon\Carbon::parse(date("Y-m-d H:i:s",$data->date_submitted))->diffInDays(Carbon\Carbon::now())}}</td>
                                    <td>{{data_get(config('constants.status_mantic'),$data->status)}}</td>
                                    <td>{{data_get($data->CUSTOM_FIELD_STRING,'0.value')}}</td>
                                </tr>
                            
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>														
            </div><!-- end card-->					
        </div>
    </div>
@endsection
@section('scripts')
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#example4 thead th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" style="width: 100% !important;" placeholder="'+title+'" />' );
        } );
    
        // DataTable
        var table = $('#example4').DataTable({
        "orderable": false,
        "searchable": false,
        "ordering": false
        });

        var table = $('#example6').DataTable({
        "orderable": false,
        "searchable": false,
        "ordering": false
        });

        var table = $('#example7').DataTable({
        "orderable": false,
        "searchable": false,
        "ordering": false
        });

        // DataTable
        var table2 = $('#example2').DataTable();
    
        // Apply the search
        table.columns().every( function () {
            var that = this;
    
            $( 'input', this.header() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );
    } );
</script>
@endsection