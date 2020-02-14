@php
$langs = config('constants.lang');
$min = config('constants.minMaxLength.min');
$max = config('constants.minMaxLength.max');
@endphp
@extends('layouts.admin.master')
@section('title', __('message.edit_letter_template'))
@section('stylesheets')
<link rel="stylesheet" type="text/css" href="{{asset('css/jquery-ui.min.css')}}">
<link href="{{ asset('css/multi_lang.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/ckeditor.css') }}" media="all" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
@include('layouts.admin.breadcrumb_index', [
    'title'       => __('message.edit_reason_inject'),
    'parent_url'  => route('letter_template.index'),
    'parent_name' => __('message.edit_reason_inject'),
    'page_name'   => __('message.edit_reason_inject'),
])
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                {{ Form::open(array('url' => "admin/letter_template/{$data->id}", 'method' => 'post' ,'class'=>'form-horizontal')) }}
                @method('PUT')
                {{ Form::label('name', __('message.name'), array('class' => 'labelas')) }} <span class="text-danger">*</span>
                {{ Form::text('name', $data->name, [ 'class' => 'form-control item-price','placeholder' => __('message.name'), 'required']) }}<br/>

                {{ Form::label('template', __('message.template')) }}
                {{ Form::textarea('template', $data->template, ['id' => 'template_reject', 'class' => 'form-control editor']) }}<br>

                <div class="text-center tour-button">
                    <a class="btn btnt btn-secondary" href="{{url('admin/letter_template')}}">
                        {{ __('message.back')}}
                    </a>
                    <button type="submit" class="btn btnt btn-danger center-block"> {{__('message.save')}}</button> <br>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('js/ckeditor.js') }}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@endsection
