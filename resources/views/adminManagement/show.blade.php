<!-- Stored in resources/views/layouts/admin/partials/top_bar_navigation.blade.php -->

@extends('layouts.admin.master')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="breadcrumb-holder">
            <h1 class="main-title float-left">{{ __('message.staff_view')}}</h1>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="{{ url('admin/admins')}}">{{
                        __('message.staff_management')}} </a></li>
                <li class="breadcrumb-item active">{{ __('message.staff_view')}}</li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                            <!-- Table Headings -->
                        <thead>
                            <tr>
                                <th>{{ __('message.id')}} : {{$admin->id}}</th>
                            </tr>
                        </thead>
                        <!-- Table Body -->
                        <tbody>
                            <tr>
                                <!-- echo image  from storage /-->
                                <td><p class="font-weight-bold">{{ __('message.staff_image')}}</p>
                                    <div><img style="width: 300px" src='{{ asset(loadImg($admin->profile_image,"/storage/profile_image/"))}}'></div>
                                </td>
                            </tr>
                            <tr>
                                <!-- Task Name -->
                                <td><p class="font-weight-bold">{{ __('message.staff_name')}} </p><div> {{ $admin->name }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td><p class="font-weight-bold">{{ __('message.email')}}</p> <div> {{ $admin->email }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td><p class="font-weight-bold">{{ __('message.date_created')}}</p> <div> {{ $admin->created_at }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td><p class="font-weight-bold">{{ __('message.date_updated')}}</p> <div> {{ $admin->updated_at }}</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <a class="btn btn-secondary" href="{{url('admin/admins')}}">
                        {{ __('message.back')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
