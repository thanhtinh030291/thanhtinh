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
                <!-- Start content -->
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="breadcrumb-holder">
                                    <h1 class="main-title float-left">My Profile</h1>
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item">Home</li>
                                        <li class="breadcrumb-item active">Profile</li>
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                            <!-- end row -->
                            <div class="row">
                                
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">						
                                            <div class="card mb-3">
                                                <div class="card-header">
                                                    <h3><i class="fa fa-user"></i> Profile details</h3>								
                                                </div>
                                                    
                                                <div class="card-body">
                                                    
                                                    
                                                    <form action="#" method="post" enctype="multipart/form-data">
                                    
                                                    <div class="row">	
                                                    
                                                    <div class="col-lg-9 col-xl-9">
                                                        
                                                        <div class="row">				
                                                            <div class="col-lg-6">
                                                            <div class="form-group">
                                                                {{ Form::label('name','Full Name', array('class' => 'labelas')) }} <span class="text-danger">*</span>
                                                                {{ Form::text('name', $user->name, [ 'class' => 'form-control ','placeholder' => __('message.name'), 'required']) }}<br/>
                                                            </div>
                                                            </div>
    
                                                            <div class="col-lg-6">
                                                            <div class="form-group">
                                                                {{ Form::label('name','E-Mail', array('class' => 'labelas')) }} <span class="text-danger">*</span>
                                                                {{ Form::text('name', $user->email, [ 'class' => 'form-control ','placeholder' =>'Email', 'required']) }}<br/>
                                                            </div>
                                                            </div>  
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                            <button type="button" class="btn btn-primary">Edit profile</button>
                                                            </div>
                                                        </div>
                                                    
                                                    </div>
                                                    
                                                    
                                                    
                                                    <div class="col-lg-3 col-xl-3 border-left">
                                                        <b>Register date: </b>: {{$user->created_at}}
                                                        
                                                        <div class="m-b-10"></div>
                                                        
                                                        <div id="avatar_image">
                                                            <img alt="image" style="max-width:100px; height:auto;" src="{{url('images/avatars/admin.png')}}" />
                                                            <br />
                                                            <i class="fa fa-trash-o fa-fw"></i> <a class="delete_image" href="#">Remove avatar</a>
                                                                        
                                                        </div>  
                                                        <div id="image_deleted_text"></div>                      
    
                                                        
                                                        <div class="m-b-10"></div>
                                                        
                                                        <div class="form-group">
                                                        <label>Change avatar</label> 
                                                        <input type="file" name="image" class="form-control">
                                                        </div>
                                                        
                                                    </div>
                                                    </div>								
                                                    
                                                    </form>										
                                                    
                                    </div>	
                                    <!-- end card-body -->								
                                        
                                </div>
                                <!-- end card -->					
    
                            </div>
                            <!-- end col -->	                                  
                    </div>
                    <!-- end row -->	
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('plugins/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('js/tinymce.js') }}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@endsection
