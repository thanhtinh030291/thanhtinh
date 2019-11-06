@extends('layouts.admin.master')
@section('title', 'Room And Board')
@section('stylesheets')
<link rel="stylesheet" type="text/css" href="{{asset('css/jquery-ui.min.css')}}">
@endsection
@section('content')
    @include('layouts.admin.breadcrumb_index', [
        'title'       => 'Room And Board',
        'parent_url'  => route('roomAndBoards.index'),
        'parent_name' => 'Room And Boards',
        'page_name'   =>  'Room And Board',
    ])
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => 'roomAndBoards.store']) !!}
                        @include('room_and_boards.fields')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
