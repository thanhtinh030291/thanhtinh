<!-- Stored in resources/views/layouts/admin/partials/top_bar_navigation.blade.php -->
@extends('layouts.admin.master')
@section('title', __('message.google_cloud_vision_API'))
@section('stylesheets')
    <link href="{{ asset('css/condition_advance.css?vision=') .$vision }}" media="all" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
@include('layouts.admin.breadcrumb_index', [
    'title'       => __('message.form_claim_ocr'),
    'page_name'   => __('message.form_claim_ocr'),
])
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary pull-right" href="{{url('admin/claim/create')}}">
            {{ __('message.create_claim')}}
        </a>
    </div>
</div>
<br>

<div class="row">
    <div class="col-md-12">
        {{ Form::open(array('url' => '/admin/claim', 'method' => 'get')) }}
        <div class="card">
            <div class="card-header">
                <label  class="font-weight-bold" for="search"> {{ __('message.search')}}</label>
            </div>
            <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            {{ Form::label('name', __('message.id_claim'), array('class' => 'labelas')) }}
                            {{ Form::select('code_claim',[], $finder['code_claim'], ['class' => 'code_claim form-control']) }}

                            {{ Form::label('created_user', __('message.account_create'), ['class' => 'labelas']) }}
                            {{ Form::select('created_user', $admin_list, data_get($finder ,'created_user'), ['id' => 'created_user', 'class' => 'select2 form-control', 'placeholder' => ' ']) }}
                            
                            {{ Form::label('created_at', __('message.date_created'), ['class' => 'labelas']) }}
                            {{ Form::text('created_at', data_get($finder,'created_at'), ['class' => 'form-control datepicker']) }}

                            {{ Form::label('team', 'Team', ['class' => 'labelas']) }}
                            {{ Form::select('team', $list_team, $team, ['id' => 'created_user', 'class' => 'select2 form-control', 'placeholder' => ' ']) }}
                            
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('letter_status', 'Latest Letter status', ['class' => 'labelas']) }}
                            {{ Form::select('letter_status', $list_status, data_get($finder, 'letter_status'), ['id' => 'updated_user', 'class' => 'select2 form-control', 'placeholder' => ' ']) }}

                            {{ Form::label('updated_user', __('message.account_edit'), ['class' => 'labelas']) }}
                            {{ Form::select('updated_user', $admin_list, data_get($finder, 'updated_user'), ['id' => 'updated_user', 'class' => 'select2 form-control', 'placeholder' => ' ']) }}
                            
                            {{ Form::label('updated_at', __('message.date_updated'), ['class' => 'labelas']) }}
                            {{ Form::text('updated_at', data_get($finder, 'updated_at'), ['class' => 'form-control datepicker']) }}
                        </div>
                    </div>
                    <br>
                {{ Form::submit( __('message.search'), ['class' => 'btn btn-info']) }}
                <button type="button" id="clearForm" class="btn btn-default"> {{ __('message.reset')}}</button>    
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <label class="font-weight-bold">{{ __('message.claim_list')}} | {{ __('message.total')}}: {{$datas->total()}} </label>
            </div>
            <div class="card-body">
                @if (count($datas) > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('message.id_claim')}}</th>
                                <th>Latest Letter status</th>
                                <th>{{ __('message.account_create')}}</th>
                                <th>{{ __('message.account_edit')}}</th>
                                <th>{{ __('message.date_created')}}</th>
                                <th>{{ __('message.date_updated')}}</th>
                                <th class='text-center'>{{ __('message.control')}}</th>
                            </tr>
                        </thead>
                        @foreach ($datas as $data)
                        <tbody>
                            <tr>
                                <td>{{$data->code_claim_show}}</td>
                                <td>
                                    @if(isset($data->export_letter[0]->status))
                                        <h4 class="p-0 text-primary">{{ data_get($list_status,  $data->export_letter_last->status, "New") }} </h4>
                                        <span class="p-1 mb-2 bg-danger text-white col-md-8  align-middle">{{ formatPrice(data_get($data->export_letter_last->info, "approve_amt"), ' đ') }} </span>
                                    @endif
                                </td>
                                <td>{{ $admin_list[$data->created_user] }}</td>
                                <td>{{ $admin_list[$data->updated_user] }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>{{ $data->updated_at }}</td>
                                <td style = "width : 15%" class='text-center'>
                                    <a class="btn btn-primary" href='{{url("admin/claim/$data->id")}}'>{{__('message.view')}}</a>
                                    @can('update', $data)
                                        <a class="btn btn-success" href='{{url("admin/claim/$data->id/edit")}}' @can('update', $data) @endcan>{{__('message.edit')}}</a>
                                    @endcan
                                    @can('delete', $data)
                                        <button type="button" class="btn btn-danger btn-delete" data-url="{{ route('claim.destroy', $data->id) }}"
                                        data-toggle="modal" data-target="#deleteConfirmModal">{{__('message.delete')}}</button>
                                    @endcan
                                </td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
                {{ $datas->appends($finder)->links()}}
                {{ __('message.showing') .' '. $datas->firstItem() .' '. __('message.to') .' '. $datas->lastItem() .' '. __('message.of_total') .' '. $datas->total() }}
                @endif
            </div>
        </div>
    </div>
</div>



@include('layouts.admin.partials.delete_model', [
    'title'           => __('message.delete_claim_confirm'),
    'confirm_message' => __('message.delete_claim_confirm'),
])
@endsection

@section('scripts')
<script src="{{asset('js/lengthchange.js?vision=') .$vision }}"></script>
<script src="{{asset('js/jquery.imgareaselect.pack.js?vision=') .$vision }}"></script>
<script>
    //ajax select code
$(window).load(function() {
    $('.code_claim').select2({          
        minimumInputLength: 2,
        ajax: {
        url: "/admin/dataAjaxHBSClaim",
            dataType: 'json',
            data: function (params) {
                return {
                    q: $.trim(params.term)
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
    //load info of claim
    $(document).on("change","#code_claim",function(){
        resultApplicant(this.value);
    });
    $( document ).ready(function() {
        var id_code = $('#code_claim').val();
        if(id_code != null){
            resultApplicant(id_code);
            
        }
    });

    function resultApplicant(value){
        var container = $("#result_applicant");
        $.ajax({
            url: "/admin/loadInfoAjaxHBSClaim",
            type: 'POST',
            
            data: {'search' : value},
        })
        .done(function(res) {
            
            container.empty();
            container.append('<p class="card-text">Full-Name: '+res.mbr_last_name +' '+res.mbr_first_name+'</p>')
            .append('<p class="card-text">Member No: '+ res.mbr_no +'</p>')
            .append('<p class="card-text">Member Ref No: '+ res.memb_ref_no +'</p>')
        })
    }
});
</script>

@endsection