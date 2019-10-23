
@extends('layouts.admin.master')
@section('title', __('message.create_ticket_category'))
@section('stylesheets')
<link rel="stylesheet" type="text/css" href="{{asset('css/jquery-ui.min.css')}}">
<link href="{{ asset('css/multi_lang.css') }}" media="all" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
@include('layouts.admin.breadcrumb_index', [
    'title'       => __('message.create_reason_inject'),
    'parent_url'  => route('list_reason_inject.index'),
    'parent_name' => __('message.list_reason_inject'),
    'page_name'   => __('message.create_reason_inject'),
])
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                {{ Form::open(array('url' => 'admin/list_reason_inject', 'method' => 'post' ,'class'=>'form-horizontal')) }}
                
                    {{ Form::label('name', __('message.name'), array('class' => 'labelas')) }} <span class="text-danger">*</span>
                    {{ Form::text('name', old('name'), [ 'class' => 'form-control item-price','placeholder' => __('message.name'), 'required']) }}<br/>

                    {{ Form::label('term', __('message.term'), array('class' => 'labelas')) }} 
                    {{ Form::select('term', $listTerm, old('term'), ['class' => ' select2 form-control', 'placeholder' => 'None']) }}<br>

                    {{ Form::label('template_reject', __('message.remark')) }}
                    {{ Form::textarea('template_reject', old('template_reject'), ['id' => 'template_reject', 'class' => 'form-control editor']) }}<br>
                <div class="text-center tour-button">
                    <a class="btn btnt btn-secondary" href="{{url('admin/list_reason_inject')}}">
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
<script src="{{ asset('plugins/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('js/tinymce.js') }}"></script>

@endsection
