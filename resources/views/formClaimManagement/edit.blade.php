<!-- Stored in resources/views/layouts/admin/partials/top_bar_navigation.blade.php -->
@extends('layouts.admin.master')
@section('title', __('message.transport_edit'))
@section('stylesheets')
<link href="{{asset('css/fileinput.css')}}" media="all" rel="stylesheet" type="text/css"/>
<link href="{{asset('css/formclaim.css')}}" media="all" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
@include('layouts.admin.breadcrumb_index', [
    'title'       => __('message.claim_edit'),
    'parent_url'  => route('form_claim.index'),
    'parent_name' => __('message.claim_management'),
    'page_name'   => __('message.claim_edit'),
])
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                {{ Form::open(array('url' => '/admin/form_claim/'.$data->id, 'method'=>'post', 'files' => true))}} @method('PUT')
                <!-- Create tour -->
                {{ Form::hidden('_del_image' ,null, ['class' => 'form-control' , 'id'=> '_del_image']) }}<br/>
                <!-- Add file image -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="file-loading">
                                    <input id="dataImg" type="file" name="_image[]" multiple >
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{ Form::label('code_claim', __('message.code_claim'), array('class' => 'labelas')) }} <span class="text-danger">*</span>
                                {{ Form::text('code_claim', $data->code_claim, array('class' => 'form-control', 'required')) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 col-form-label ">
                                {{ Form::label('new_items_reject', __('message.new_items_reject'), array('class' => 'card-title')) }}
                            </div>
                            <div class="col-sm-9">
                                <button type="button" class="btn btn-secondary mt-2 btnt" onclick="addInputItem()">{{ __('message.add')}}</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="card table-responsive col-md-9"  style="max-height:450px">
                                <table id="season_price_tbl" class="table table-striped header-fixed">
                                    <thead>
                                        <tr>
                                            <th>{{ __('message.content')}}</th>
                                            <th>{{ __('message.amount')}}</th>
                                            <th>{{ __('message.reason_reject')}}</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="empty_item" style="display: none;">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr id="clone_item" style="display: none">
                                            <td>{{ Form::text('_content_default', null, ['class' => 'form-control', 'onkeydown'=>'search2(this)' ]) }}</td>
                                            <td style="width:180px">
                                                {{ Form::text('_amount_default', null, ['class' => 'item-price form-control']) }}
                                            </td>
                                            <td style="width:480px">
                                                <div style="width:480px">
                                                    {{ Form::select('_reasonInject_default', $listReasonInject,null, ['class' => ' form-control ', 'placeholder' => 'Not Reject']) }}
                                                </div>
                                            </td>
                                            <td style="width:80px">
                                                <button type="button"class="delete_btn btn btn-danger  p-0">&#x2613;</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card col-md-3">
                                <div class="card-body"> 
                                    <h5 class="card-title">Suggestions </h5>
                                    <div id="result_suggestions">
        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <a class="btn btn-secondary btnt" href="{{url('admin/transport')}}">
                        {{ __('message.back')}}
                    </a>
                    <button type="submit" class="btn btn-danger center-block btnt" style="margin-left: 20px"> {{__('message.save')}}</button> <br>
                </div>
                <!-- End file image -->
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{asset('js/fileinput.js')}}"></script>
<script src="{{asset('js/papaparse.min.js')}}"></script>
<script src="{{asset('js/popper.min.js')}}" ></script>
<script src="{{ asset('js/tiff.min.js') }}"></script>
<script src="{{asset('js/formclaim.js')}}"></script>
<script src="{{ asset('js/format-price.js') }}"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>

<script>
var dataImage = @json($dataImage);
var previewConfig = @json($previewConfig);
var maxFile = 1;
$('#dataImg').fileinput({
    maxFileCount: maxFile,
    overwriteInitial: true,
    validateInitialCount: true,
    initialPreview: dataImage,
    initialPreviewConfig: previewConfig,
});
var str_key = [];
$('#dataImg').on('filedeleted', function(event, key, jqXHR, data) {
    str_key.push(key);
    $('#_del_image').val(str_key);
});

$(document).on('ready', function() {
    var content = @json(old('_content'));
    content = content ? content : @json($data->item_of_claim->pluck('content'));
    var amount = @json(old('_amount'));
    amount = amount ? amount : @json($data->item_of_claim->pluck('amount'));
    var reasonInject = @json(old('_reasonInject'));
    reasonInject = reasonInject ? reasonInject : @json($data->item_of_claim->pluck('list_reason_inject_id'));
    var idItem = @json(old('_idItem'));
    idItem = idItem ? idItem : @json($data->item_of_claim->pluck('id'));
    if(content != null){
        $.each(content, function (index, value) {
            addInputItem();
            addValueItem(content[index],amount[index],reasonInject[index],count-1,idItem[index]);
        });
    }
});
</script>


<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

@endsection
