<!-- Stored in resources/views/layouts/admin/partials/top_bar_navigation.blade.php -->
@extends('layouts.admin.master')
@section('title', __('message.transport_management'))
@section('stylesheets')
    <link href="{{ asset('css/condition_advance.css') }}" media="all" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
@include('layouts.admin.breadcrumb_index', [
    'title'       => __('message.transport_management'),
    'page_name'   => __('message.transport_management'),
])
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary pull-right" href="{{url('admin/transport/create')}}">
            {{ __('message.create_transport')}}
        </a>
    </div>
</div>
<br>

<div class="row">
    <div class="col-md-12">
        {{ Form::open(array('url' => '/admin/transport', 'method' => 'get')) }}
        <div class="card">
            <div class="card-header">
                <label  class="font-weight-bold" for="search"> {{ __('message.search')}}</label>
            </div>
            <div class="card-body">
                <div class="row" style="padding: 0 10px 10px 0">
                   
                </div>
                {{ Form::submit( __('message.search'), ['class' => 'btn btn-info']) }}
                <button type="button" id="clearForm" class="btn btn-default"> {{ __('message.reset')}}</button>    
            </div>
        </div>
       
        {{ Form::close() }}
    </div>
</div>



@include('layouts.admin.partials.delete_model', [
    'title'           => __('message.delete_transport_warning'),
    'confirm_message' => __('message.delete_transport_confirm'),
])
@endsection

@section('scripts')
<script src="{{asset('js/lengthchange.js')}}"></script>

@endsection