<!-- Stored in resources/views/layouts/admin/partials/top_bar_navigation.blade.php -->
@extends('layouts.admin.master')
@section('title', __('message.google_cloud_vision_API'))
@section('stylesheets')
    <link href="{{ asset('css/condition_advance.css') }}" media="all" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
@include('layouts.admin.breadcrumb_index', [
    'title'       => __('message.form_claim_orc'),
    'page_name'   => __('message.form_claim_orc'),
])
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary pull-right" href="{{url('admin/claim/create')}}">
            {{ __('message.create_claim')}}
        </a>
    </div>
</div>
<br>

<div class="row">
    <div class="col-md-12">
        {{ Form::open(array('url' => '/admin/claim', 'method' => 'get')) }}
        <div class="card">
            <div class="card-header">
                <label  class="font-weight-bold" for="search"> {{ __('message.search')}}</label>
            </div>
            <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">                           
                            {{ Form::label('name', __('message.id_claim'), array('class' => 'labelas')) }}
                            {{ Form::text('code_claim',$finder['code_claim'], ['class' => 'form-control']) }} <br/>                          
                        </div>
                    </div>
                    <br>
                {{ Form::submit( __('message.search'), ['class' => 'btn btn-info']) }}
                <button type="button" id="clearForm" class="btn btn-default"> {{ __('message.reset')}}</button>    
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <label class="font-weight-bold">{{ __('message.claim_list')}} | {{ __('message.total')}}: {{$datas->total()}} </label>
            </div>
            <div class="card-body">
                @if (count($datas) > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('message.id_claim')}}</th>
                                <th>{{ __('message.account_create')}}</th>
                                <th>{{ __('message.account_edit')}}</th>
                                <th>{{ __('message.date_created')}}</th>
                                <th>{{ __('message.date_updated')}}</th>
                                <th class='text-center'>{{ __('message.control')}}</th>
                            </tr>
                        </thead>
                        @foreach ($datas as $data)
                        <tbody>
                            <tr>
                                <td>{{$data->codeClaimHBS}}</td>
                                <td>{{ $admin_list[$data->created_user] }}</td>
                                <td>{{ $admin_list[$data->updated_user] }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>{{ $data->updated_at }}</td>
                                <td style = "width : 15%" class='text-center'>
                                    <a class="btn btn-primary" href='{{url("admin/claim/$data->id")}}'>{{__('message.view')}}</a>
                                    @can('update', $data)
                                        <a class="btn btn-success" href='{{url("admin/claim/$data->id/edit")}}' @can('update', $data) @endcan>{{__('message.edit')}}</a>
                                    @endcan
                                    @can('delete', $data)
                                        <button type="button" class="btn btn-danger btn-delete" data-url="{{ route('claim.destroy', $data->id) }}"
                                        data-toggle="modal" data-target="#deleteConfirmModal">{{__('message.delete')}}</button>
                                    @endcan
                                </td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
                {{ $datas->appends($finder)->links()}}
                {{ __('message.showing') .' '. $datas->firstItem() .' '. __('message.to') .' '. $datas->lastItem() .' '. __('message.of_total') .' '. $datas->total() }}
                @endif
            </div>
        </div>
    </div>
</div>



@include('layouts.admin.partials.delete_model', [
    'title'           => __('message.delete_claim_confirm'),
    'confirm_message' => __('message.delete_claim_confirm'),
])
@endsection

@section('scripts')
<script src="{{asset('js/lengthchange.js')}}"></script>
<script src="{{asset('js/jquery.imgareaselect.pack.js')}}"></script>
<script>
    $(document).ready(function () {
        $('#imageSelect').imgAreaSelect({ x1: 120, y1: 90, x2: 280, y2: 210 });
    });
</script>

@endsection