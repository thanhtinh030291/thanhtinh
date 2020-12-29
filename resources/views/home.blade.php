<!-- Stored in resources/views/layouts/admin/partials/top_bar_navigation.blade.php -->
@extends('layouts.admin.master')
@section('title', 'PanciFic-Cross-Admin')
@section('content')
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
            </div>

            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                    <div class="card-box noradius noborder bg-warning">
                            <i class="fa fa-bar-chart float-right text-white"></i>
                            <h6 class="text-white text-uppercase m-b-20">IP Address</h6>
                            <h1 class="m-b-20 text-white counter">{{250}}</h1>
                    <span class="text-white">My IP: {{$Ipclient}}</span>
                    </div>
            </div>

            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                    <div class="card-box noradius noborder bg-info">
                            <i class="fa fa-user-o float-right text-white"></i>
                            <h6 class="text-white text-uppercase m-b-20">Users</h6>
                            <h1 class="m-b-20 text-white counter">{{$sumMember}}</h1>
                            <span class="text-white">{{$sumMember}} New Users</span>
                    </div>
            </div>

            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                    <div class="card-box noradius noborder bg-danger">
                            <i class="fa fa-bell-o float-right text-white"></i>
                            <h6 class="text-white text-uppercase m-b-20">Alerts</h6>
                            <h1 class="m-b-20 text-white counter">58</h1>
                            <span class="text-white">5 New Alerts</span>
                    </div>
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
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>LINK ETALK</th>
                                    <th>Claim No</th>
                                    <th>Summary</th>
                                    <th>Date Submitted</th>
                                    <th>Last Updated</th>
                                    <th>Days</th>
                                    <th>Current Status</th>
                                    <th>Reason For Pending</th>
                                </tr>
                            </thead>
                            @foreach ($MANTIS_BUG as $data)
                            <tbody>
                                <tr bgcolor={{ data_get($STATUS_COLOR_LIST,$data->status) }}>
                                    <td>
                                        <a class="btn btn-primary" target="_blank" href="{{config('constants.url_mantic').'view.php?id='.$data->id }}">{{$data->id}}</a>
                                    </td>
                                    <td>{{data_get($data->HBS_DATA,'cl_no')}}</td>
                                    <td>{{$data->summary}}</td>
                                    <td>{{date("Y-m-d H:i:s",$data->date_submitted)}}</td>
                                    <td>{{date("Y-m-d H:i:s",$data->last_updated)}}</td>
                                    <td>{{ Carbon\Carbon::parse(date("Y-m-d H:i:s",$data->date_submitted))->diffInDays(Carbon\Carbon::now())}}</td>
                                    <td>{{data_get(config('constants.status_mantic'),$data->status)}}</td>
                                    <td>{{data_get($data->CUSTOM_FIELD_STRING,'0.value')}}</td>
                                </tr>
                            </tbody>
                            @endforeach
                        </table>
                </div>														
            </div><!-- end card-->					
        </div>
    </div>
@endsection