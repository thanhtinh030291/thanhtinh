<!-- Stored in resources/views/layouts/admin/partials/top_bar_navigation.blade.php -->
@extends('layouts.admin.master')
@section('title', __('message.google_cloud_vision_API'))
@section('stylesheets')
    <link href="{{ asset('css/condition_advance.css') }}" media="all" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
@include('layouts.admin.breadcrumb_index', [
    'title'       => __('message.google_cloud_vision_API'),
    'page_name'   => __('message.google_cloud_vision_API'),
])
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary pull-right" href="{{url('admin/form_claim/create')}}">
            {{ __('message.create_claim')}}
        </a>
    </div>
</div>
<br>

<div class="row">
    <div class="col-md-12">
        {{ Form::open(array('url' => '/admin/google_cloud_vision', 'method' => 'get')) }}
        <div class="card">
            <div class="card-header">
                <label  class="font-weight-bold" for="search"> {{ __('message.search')}}</label>
            </div>
            <div class="card-body">
                <div class="row" style="padding: 0 10px 10px 0">    
                    <img id="duck" src="duck.jpg" alt="Why did the duck cross the road?" title="Why did the duck cross the road?">
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
<script src="{{asset('js/jquery.imgareaselect.pack.js')}}"></script>
<script>
    $(document).ready(function () {
        $('#imageSelect').imgAreaSelect({ x1: 120, y1: 90, x2: 280, y2: 210 });
    });
</script>

@endsection