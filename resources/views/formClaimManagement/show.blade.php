<!-- Stored in resources/views/layouts/admin/partials/top_bar_navigation.blade.php -->
@php

@endphp
@extends('layouts.admin.master')
@section('title', __('message.transport_view'))
@section('stylesheets')
    <link href="{{asset('css/fileinput.css')}}" media="all" rel="stylesheet" type="text/css"/>
    
    <style type="text/css">
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

        .file-caption-main, .kv-file-remove{
            display: none;
        }
    </style>
@endsection
@section('content')
@include('layouts.admin.breadcrumb_index', [
    'title'       => __('message.claim_create'),
    'parent_url'  => route('form_claim.index'),
    'parent_name' => __('message.claim_management'),
    'page_name'   => __('message.claim_view'),
])
<div class="row">
    <div class="col-md-12">
        <div class="card"> 
            <div class="card-body">
            
                <div class="row">
                    <div class="col-md-8">
                        {{ Form::label('type','Form default:', array('class' => '')) }} <span class="text-danger"> </span>
                        <a href="{{$dataImage}}" download>
                            <img src="{{ asset('images/download-button.png') }}"  width="160" height="80">
                        </a>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            {{ Form::label('type',  __('message.id_claim'), array('class' => 'col-md-4')) }}
                            {{ Form::label('type', $data->code_claim , array('class' => 'col-md-8')) }}

                            {{ Form::label('type',  __('message.account_create'), array('class' => 'col-md-4')) }}
                            {{ Form::label('type', $admin_list[$data->updated_user] , array('class' => 'col-md-8')) }} 

                            {{ Form::label('type',  __('message.account_edit'), array('class' => 'col-md-4')) }} 
                            {{ Form::label('type', $admin_list[$data->updated_user] , array('class' => 'col-md-8')) }}

                            {{ Form::label('type',  __('message.date_created'), array('class' => 'col-md-4')) }} 
                            {{ Form::label('type', $data->created_at , array('class' => 'col-md-8')) }}

                            {{ Form::label('type',  __('message.date_updated'), array('class' => 'col-md-4')) }} 
                            {{ Form::label('type', $data->updated_at , array('class' => 'col-md-8')) }}


                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <a class="btn btn-secondary btnt" href="{{url('admin/form_claim')}}">{{ __('message.back')}}</a>
                </div>
                <!-- End file image -->
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                
            </div>
            <div class="card-body">
                @if (count($items) > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('message.content')}}</th>
                                <th>{{ __('message.unit_price')}}</th>
                                <th>{{ __('message.quantity')}}</th>
                                <th>{{ __('message.amount')}}</th>
                                <th>{{ __('message.status')}}</th>
                            </tr>
                        </thead>
                        @foreach ($items as $data)
                        <tbody>
                            <tr>
                                <td>{{$data->content}}</td>
                                <td>{{$data->unit_price}}</td>
                                <td>{{$data->quantity}}</td>
                                <td>{{$data->amount}}</td>
                                @if ($data->status == 1)
                                <td>
                                    <input type="checkbox" class="custom-control-input "  checked  value = "1">
                                    <span class="custom-control-indicator"></span>
                                </td>
                                @endif
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
                
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{asset('plugins/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('js/fileinput.js')}}"></script>
<script src="{{ asset('js/multi_lang.js') }}"></script>
<script src="{{ asset('js/format-price.js') }}"></script>
<script src="{{ asset('js/checkbox-active.js') }}"></script>
@endsection
