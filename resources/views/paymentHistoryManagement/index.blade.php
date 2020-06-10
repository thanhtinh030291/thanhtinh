@extends('layouts.admin.master')
@section('title', 'payment history')
@section('stylesheets')
    <link href="{{ asset('css/condition_advance.css?vision=') .$vision }}" media="all" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
@include('layouts.admin.breadcrumb_index', [
    'title'       => 'Payment History',
    'page_name'   => 'Payment History',
])

<br>
<div class="row">
    <div class="col-md-12">
        <form action="{{ url('admin/PaymentHistory') }}" method="GET" class="form-horizontal" >
            <div class="card">
                <div class="card-header">
                    <label  class="font-weight-bold" for="searchmail"> {{ __('message.search')}}</label>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            {{ Form::label('name_en', __('message.name'), ['class' => 'labelas']) }}
                            {{ Form::text('name', $search_params['name'], ['class' => 'form-control']) }}
                        </div>
                        {{-- <div class="col-md-6">
                            {{ Form::label('created_user', __('message.account_create'), ['class' => 'labelas']) }}
                            {{ Form::select('created_user', $admin_list, $search_params['created_user'], ['id' => 'created_user', 'class' => 'select2 form-control', 'placeholder' => ' ']) }}
                            {{ Form::label('created_at', __('message.date_created'), ['class' => 'labelas']) }}
                            {{ Form::text('created_at', $search_params['created_at'], ['class' => 'form-control datepicker']) }}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('updated_user', __('message.account_edit'), ['class' => 'labelas']) }}
                            {{ Form::select('updated_user', $admin_list, $search_params['updated_user'], ['id' => 'updated_user', 'class' => 'select2 form-control', 'placeholder' => ' ']) }}
                            {{ Form::label('updated_at', __('message.date_updated'), ['class' => 'labelas']) }}
                            {{ Form::text('updated_at', $search_params['updated_at'], ['class' => 'form-control datepicker']) }}
                        </div> --}}
                    </div>
                    <br>
                    <button type="submit" class="btn btn-info">{{ __('message.search') }}</button>
                    <button type="button" id="clearForm" class="btn btn-default">{{ __('message.reset') }}</button>
                </div>
            </div>
            @include('layouts.admin.partials.condition_advance', ['limit_list' => $limit_list, 'limit' => $limit, 'list' => $data, 'urlPost' => route('product.index'), 'search_params' => $search_params])
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                @if (count($data) > 0)
                {{ $data->appends($search_params)->links() }}
                @endif
            </div>
            <div class="card-body">
                @if (count($data) > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <!-- Table Headings -->
                        <thead>
                            <tr>
                                <th>CL_NO</th>
                                <th>MEMB_NAME</th>
                                <th>MEMB_REF_NO</th>
                                <th>POCY_REF_NO</th>
                                <th>PRES_AMT</th>
                                <th>APP_AMT</th>
                                <th>TF_AMT</th>
                                <th>created user</th>
                                <th>created at</th>
                                <th class='text-center control_btn'>{{ 
                                    __('message.control')
                                }}</>
                            </tr>
                        </thead>
                        <!-- Table Body -->
                        @foreach ($data as $value)
                        <tbody>
                            <tr>
                                <!-- ticket info -->
                                <td>{{ $value->CL_NO }}</td>
                                <td>{{ $value->MEMB_NAME }}</td>
                                <td>{{ $value->MEMB_REF_NO }}</td>
                                <td>{{ $value->POCY_REF_NO }}</td>
                                <td class="text-danger font-weight-bold">{{ formatPrice($value->PRES_AMT) }}</td>
                                <td class="text-danger font-weight-bold">{{ formatPrice($value->APP_AMT) }}</td>
                                <td class="text-danger font-weight-bold">{{ formatPrice($value->TF_AMT) }}</td>
                                <td>{{ $admin_list[$value->created_user] }}</td>
                                <td>{{ $value->created_at }}</td>
                                <td class='text-center'>
                                    <!-- control -->
                                    <a class="btn btn-primary" href='{{ url("admin/PaymentHistory/$value->id") }}'>{{ __('message.view') }}</a>
                                </td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
                {{ $data->appends($search_params)->links() }}
                @endif
            </div>
        </div>
    </div>
</div>

@include('layouts.admin.partials.delete_model', [
    'title'           => __('message.product_warning'),
    'confirm_message' => __('message.product_confirm'),
])

@endsection
@section('scripts')
<script src="{{asset('js/lengthchange.js?vision=') .$vision }}"></script>
@endsection
