@extends('layouts.admin.master')
@section('title', 'Room And Boards')
@section('stylesheets')
    <link href="{{ asset('css/condition_advance.css') }}" media="all" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include('layouts.admin.breadcrumb_index', [
        'title'       => 'Room And Boards',
        'page_name'   => 'Room And Boards',
    ])
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-primary pull-right" href="{!! route('roomAndBoards.create') !!}">
                {{ __('message.create')}}
            </a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ url('admin/product') }}" method="GET" class="form-horizontal" >
                <div class="card">
                    <div class="card-header">
                        <label  class="font-weight-bold" for="searchmail"> {{ __('message.search')}}</label>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
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
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-info">{{ __('message.search') }}</button>
                        <button type="button" id="clearForm" class="btn btn-default">{{ __('message.reset') }}</button>
                    </div>
                </div>
                @include('layouts.admin.partials.condition_advance', ['limit_list' => $limit_list, 'limit' => $limit, 'list' => $roomAndBoards, 'urlPost' => route('roomAndBoards.index'), 'search_params' => $search_params])
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @if (count($roomAndBoards) > 0)
                        {{ $roomAndBoards->appends($search_params)->links() }}
                    @endif
                </div>
                <div class="card-body">
                    @if (count($data) > 0)
                        <div class="table-responsive">
                            @include('room_and_boards.table')
                        </div>
                        {{ $roomAndBoards->appends($search_params)->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{ $roomAndBoards->appends($search_params)->links() }} 
@endsection
@section('scripts')
    <script src="{{asset('js/lengthchange.js')}}"></script>
@endsection

