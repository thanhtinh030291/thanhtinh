<!-- Stored in resources/views/layouts/admin/partials/top_bar_navigation.blade.php -->
@php
$sum = 0;
$totalAmount = 0;
@endphp
@extends('layouts.admin.master')
@section('title', __('message.claim_view'))
@section('stylesheets')
    <link href="{{asset('css/fileinput.css')}}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/formclaim.css')}}" media="all" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
@include('layouts.admin.breadcrumb_index', [
    'title'       => __('message.claim_create'),
    'parent_url'  => route('claim.index'),
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
                    <a class="btn btn-secondary btnt" href="{{url('admin/claim')}}">{{ __('message.back')}}</a>
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
                    <label  class="font-weight-bold" for="letter">{{__('message.letter')}}</label>
            </div> 
            <div class="card-body">
                @foreach ($items as $data)
                    @php
                        if($data->list_reason_inject_id){
                            $sum += removeFormatPrice($data->amount);
                        
                    @endphp
                        <h5 class="text-danger font-weight-bold"> - Chi phí " {{$data->content}} " ( {{$data->amount}} ) không được thanh toán do thuộc điều khoản " {{data_get($listReasonInject, $data->list_reason_inject_id, "")}} " .
                        </h5>
                    @php
                        }
                    @endphp
                @endforeach
                    
                <div class="row d-flex justify-content-end mt-5">
                    <button type="button"  class="btn btn-secondar col-md-3">Tổng Chi Phí Không Thanh Toán</button>
                    <p id="totalAmount" class="col-md-4 bg-danger p-2 m-0 font-weight-bold text-white">{{formatPrice($sum)}}</p>
                </div>
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
                <div >
                    <table class="table table-primary table-hover">
                        <tbody>
                            <tr>
                                <th>{{ __('message.content')}}</th>
                                <th>{{ __('message.amount')}}</th>
                                <th>{{ __('message.status')}}</th>
                                <th>{{ __('message.reason_reject')}}</th>
                            </tr>
                        
                        
                            @foreach ($items as $data)
                            <tr>
                                <td>{{$data->content}}</td>
                                <td>{{$data->amount}}</td>
                                @php
                                    $totalAmount += removeFormatPrice($data->amount);
                                @endphp
                                <td>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input " disabled readonly {{ $data->list_reason_inject_id ? "" : 'checked' }}>
                                        <span class="custom-control-indicator"></span>
                                    </label>
                                </td>
                                <td>
                                    @if($data->list_reason_inject_id)
                                        <p class="text-danger font-weight-bold">{{ $data->list_reason_inject->name}}</p>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                    <div class="row d-flex justify-content-end">
                        <button type="button"  class="btn btn-secondar col-md-3">Total Amount</button>
                        <p id="totalAmount" class="col-md-4 bg-danger p-2 m-0 font-weight-bold text-white">{{formatPrice($totalAmount)}}</p>
                    </div>
                </div>
                
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{asset('js/fileinput.js')}}"></script>
<script src="{{ asset('js/format-price.js') }}"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{asset('js/popper.min.js')}}" ></script>
@endsection
