@extends('layouts.admin.master')
@section('title', 'Claim Word Sheet')
@section('stylesheets')
    <link href="{{ asset('css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-ui.min.css') }}">
    <link href="{{ asset('css/setting_date.css') }}" media="all" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include('layouts.admin.breadcrumb_index', [
        'title'       => 'Claim Word Sheet',
        'parent_url'  =>  route('claimWordSheets.index'),
        'parent_name' => 'Claim Word Sheets',
        'page_name'   => 'Claim Word Sheet',
    ])
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @include('claim_word_sheets.show_fields')
                    <a href="{!! route('claimWordSheets.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
