<!-- Stored in resources/views/layouts/admin/partials/top_bar_navigation.blade.php -->
@php

@endphp
@extends('layouts.admin.master')
@section('title', __('message.transport_view'))
@section('stylesheets')
    <link href="{{asset('css/fileinput.css')}}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/setting_date.css') }}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/multi_lang.css') }}" media="all" rel="stylesheet" type="text/css"/>
    <style type="text/css">
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
                    <div class="col-sm-2 col-form-label d-flex justify-content-end">
                        {{ Form::label('type','Form default:', array('class' => '')) }} <span class="text-danger"> </span>
                    </div>
                    <div class="col-sm-4">
                        <a href="{{$dataImage}}" download>
                        <img src="{{ asset('images/download-button.png') }}"  width="160" height="80">
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 col-form-label d-flex justify-content-end">
                        {{ Form::label('type','Form ORC:', array('class' => '')) }} <span class="text-danger"> </span>
                    </div>
                    <div class="col-sm-4">
                        <a href="{{$dataExport}}" download>
                        <img src="{{ asset('images/download-button.png') }}"  width="160" height="80">
                        </a>
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
@endsection

@section('scripts')
<script src="{{asset('plugins/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('js/fileinput.js')}}"></script>
<script src="{{ asset('js/multi_lang.js') }}"></script>
<script src="{{ asset('js/format-price.js') }}"></script>
<script src="{{ asset('js/checkbox-active.js') }}"></script>
@endsection
