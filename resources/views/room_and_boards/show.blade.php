@extends('layouts.admin.master')
@section('title', 'Room And Board')
@section('stylesheets')
    <link href="{{ asset('css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-ui.min.css') }}">
    <link href="{{ asset('css/setting_date.css') }}" media="all" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include('layouts.admin.breadcrumb_index', [
        'title'       => 'Room And Board',
        'parent_url'  =>  route('roomAndBoards.index'),
        'parent_name' => 'Room And Boards',
        'page_name'   => 'Room And Board',
    ])
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @include('room_and_boards.show_fields')
                    <a href="{!! route('roomAndBoards.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
