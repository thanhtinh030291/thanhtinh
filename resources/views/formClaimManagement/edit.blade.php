<!-- Stored in resources/views/layouts/admin/partials/top_bar_navigation.blade.php -->
@php
$min = Config::get('constants.minMaxLength.min');
$max = Config::get('constants.minMaxLength.max');
$maxHours = Config::get('constants.max_hours');
$minPrice = config('constants.minMaxLengthPrice.min');
$maxPrice = config('constants.minMaxLengthPrice.max');
$minNumber = config('constants.minMaxLengthNumber.min');
$maxNumber = config('constants.minMaxLengthNumber.max');
$optionArray = Config::get('constants.optionTrans');
$checkbox = Config::get('constants.checkbox');
$valueOption = $transport->type? $optionArray[$transport->type] : [];
$langs = config('constants.lang');
@endphp
@extends('layouts.admin.master')
@section('title', __('message.transport_edit'))
@section('stylesheets')
    <link href="{{asset('css/fileinput.css')}}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/setting_date.css') }}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/multi_lang.css') }}" media="all" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
@include('layouts.admin.breadcrumb_index', [
    'title'       => __('message.transport_edit'),
    'parent_url'  => route('transport.index'),
    'parent_name' => __('message.transport_management'),
    'page_name'   => __('message.transport_edit'),
])
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                {{ Form::open(array('url' => '/admin/transport/'.$transport->id, 'method'=>'post', 'files' => true))}} @method('PUT')
                <!-- Create tour -->
                {{ Form::hidden('_del_image' ,null, ['class' => 'form-control' , 'id'=> '_del_image']) }}<br/>
                <!-- Add file image -->
                <div class="row">
                    <div class="col-md-9">
                        @include('layouts.admin.multi_lang', [
                            'lang_list'   => $langs,
                            'name_submit' => 'name',
                            'label_name'  => __('message.trans_name'),
                            'placeholder' => __('message.enter_name'),
                            'floor'       => $min,
                            'ceil'        => $max,
                            'data'        => $transport
                        ])
                        <div class="row">
                            <div class="col-sm-2 col-form-label d-flex justify-content-end">
                                {{ Form::label('type', __('message.type'), array('class' => '')) }} <span class="text-danger">*</span>
                            </div>
                            <div class="col-sm-4">
                                {{ Form::select('type', Config::get('constants.typeTrans'), $transport->type, ['id' => 'typeTrans','class' => 'select2 form-control', 'required', 'disabled', 'placeholder' => __('message.please_select')]) }}
                            </div>
                        </div>
                        <div class=" row">
                            <div class="col-sm-2 col-form-label d-flex justify-content-end">
                                {{ Form::label('option', __('message.option'), array('class' => 'labelas')) }} <span class="text-danger">*</span>
                            </div>
                            <div class="col-sm-4">
                                {{ Form::select('option', $valueOption , $transport->option, [ 'id'=>'optionTrans','class' => 'select2 form-control', 'required', 'placeholder' => __('message.please_select')]) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 col-form-label d-flex justify-content-end">
                                {{ Form::label('depart_place', __('message.depart_place'), array('class' => 'labelas')) }} <span class="text-danger">*</span>
                            </div>
                            <div class="col-sm-4">
                                {{ Form::select('depart_place', Config::get('constants.stationList'), $transport->depart_place, [ 'class' => 'select2 form-control', 'required', 'placeholder' => __('message.please_select')]) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 col-form-label d-flex justify-content-end">
                                {{ Form::label('arrival_place', __('message.arrival_place'), array('class' => 'labelas')) }} <span class="text-danger">*</span>
                            </div>
                            <div class="col-sm-4">
                                    {{ Form::select('arrival_place', Config::get('constants.stationList') , $transport->arrival_place, [ 'class' => 'select2 form-control', 'required', 'placeholder' => __('message.please_select')]) }}
                            </div>
                        </div>
                        @include('layouts.admin.multi_lang', [
                            'lang_list'   => $langs,
                            'name_submit' => 'details',
                            'label_name'  => __('message.trans_info'),
                            'class'       => 'editor',
                            'type'        => 'textarea',
                            'data'        => $transport,
                            'required'    => false
                        ])
                        <div class="row">
                            <div class="col-sm-2 col-form-label d-flex justify-content-end">
                                {{ Form::label('price_adult', __('message.price_adult'), array('class' => 'labelas' )) }} <span class="text-danger">*</span>
                            </div>
                            <div class="col-sm-3">
                                {{ Form::text('price_adult',$transport->price_adult, ['min' => $minPrice, 'max' => $maxPrice, 'class' => 'form-control item-price','placeholder' => __('message.enter_price'), 'required']) }}
                            </div>
                            <div class="offset-md-1 col-sm-2 col-form-label d-flex justify-content-end">
                                {{ Form::label('price_child', __('message.price_child'), array('class' => 'labelas')) }} <span class="text-danger">*</span>
                            </div>
                            <div class="col-sm-3">
                                {{ Form::text('price_child',$transport->price_child, ['min' => $minPrice, 'max' => $maxPrice, 'class' => 'form-control item-price','placeholder' => __('message.enter_price'), 'required']) }}
                            </div>
                        </div>
                        @include('layouts.admin.multi_lang', [
                            'lang_list'   => $langs,
                            'name_submit' => 'cancel_policy',
                            'label_name'  => __('message.cancel_policy'),
                            'class'       => 'editor',
                            'type'        => 'textarea',
                            'data'        => $transport,
                            'required'    => false
                        ])
                        <div class="row">
                            <div class="col-sm-2 col-form-label d-flex justify-content-end">
                                {{ Form::label('duration', __('message.duration'), array('class' => 'labelas')) }} <span class="text-danger">*</span>
                            </div>
                            <div class="col-sm-5">
                                <div class="input-group" >
                                    {{ Form::number('_hours',$hours, ['min' => '0', 'max' => $maxHours ,'class' => 'form-control', 'required']) }}
                                    {{ Form::label('hours', __('message.hours'), array('class' => 'labelas')) }}
                                    {{ Form::number('_minutes',$minutes, ['class' => 'form-control','min' => '0', 'max' => '59', 'required']) }}
                                    {{ Form::label('minutes', __('message.minutes'), array('class' => 'labelas')) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 col-form-label d-flex justify-content-end">
                                {{ Form::label('reservable_period', __('message.reservable_period'), array('class' => 'labelas')) }} <span class="text-danger">*</span>
                            </div>
                            <div class="col-sm-2">
                                {{ Form::number('reservable_period',$transport->reservable_period, ['min' => $minNumber, 'max' => $maxNumber, 'class' => 'form-control','placeholder' => __('message.enter_reservable_period'), 'required']) }}
                            </div>
                            <div class="col-sm-2">
                                {{ Form::label('reservable_period', __('message.unit_date'), array('class' => 'labelas')) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 col-form-label d-flex justify-content-end">
                                {{ Form::label('fp_recommend_order', __('message.fp_recommend_order'), array('class' => 'labelas')) }} <span class="text-danger">*</span>
                            </div>
                            <div class="col-sm-2">
                                    {{ Form::number('fp_recommend_order',$transport->fp_recommend_order, ['min' => $minNumber, 'max' => $maxNumber, 'class' => 'form-control','placeholder' => __('message.enter_fp_recommend_order'), 'required']) }}
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-sm-2 col-form-label d-flex justify-content-end">
                                    {{ Form::label('start_date', __('message.valid_period'), array('class' => 'labelas')) }} <span class="text-danger">*</span>
                                </div>
                                <div class="col-sm-2 col-form-label d-flex justify-content-end">
                                    {{ Form::label('always_active', __('message.always_active'), array('class' => 'labelas')) }}
                                </div>
                                <div class="col-sm-8" style="margin-top:12px">
                                    <div class="custom-control custom-checkbox">
                                        {{ Form::checkbox('always_active', $checkbox['on'] , $transport->always_active, array('class' => 'custom-control-input always_active' , 'id' => "always_active", 'onChange' => 'change_start_date(this.checked);' )) }}
                                        {{ Form::label('always_active',' ', array('class' => 'custom-control-label')) }}
                                    </div>
                                </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 offset-sm-2">
                                {{ Form::text('_rangeStartDate', $rangeStartDate, ['class' => 'form-control datepicker date_active']) }}
                            </div>
                            <div class="col-sm-4 input-group">
                                {{ Form::label('to', __('message.from'), array('class' => 'labelas')) }}
                                {{ Form::text('_rangeEndDate', $rangeEndDate, ['class' => 'form-control datepicker date_active ml-5 mr-3']) }}
                            </div>
                        </div><br/>
                        <div class="row">
                            <div class="col-sm-2 col-form-label d-flex justify-content-end">
                                {{ Form::label('expire_date', __('message.expire_date'), ['class' => 'labelas']) }}
                            </div>
                            <div class="col-sm-9">
                                <button type="button" class="btn btn-secondary add_field_button btnt" onclick="addInputExpire()">{{__('message.add') }}</button>
                            </div>
                        </div>
                        <div class="row">
                            <table id="expire_date_tbl" class="col-sm-7 offset-sm-2 display dataTable table_add_new">
                                <tbody>
                                    <tr id="empty_expire_date" style="display: none;">
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr id="clone_expire" style="display: none">
                                        <td>{{ Form::text('_changeStart', null, [
                                            'class' => 'form-control datepicker have_require'
                                        ]) }}</td>
                                        <td>{{__('message.from')}}</td>
                                        <td>{{ Form::text('_changeEnd', null, [
                                            'class' => 'form-control datepicker have_require'
                                        ]) }}
                                        <button type="button" class="delete_row_btn p-0">&#x2613;</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 col-form-label d-flex justify-content-end">
                                {{ Form::label('seasonPrice', __('message.season_price'), array('class' => 'labelas')) }}
                            </div>
                            <div class="col-sm-9">
                                <button type="button" class="btn btn-secondary add_field_button btnt" onclick="addInputSeason()">{{ __('message.add')}}</button>
                            </div>
                        </div>
                        <div class="row">
                                <table id="season_price_tbl" class="col-sm-10 offset-sm-2 display dataTable table_add_new">
                                <tbody>
                                    <tr id="empty_season_price" style="display: none;">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr id="clone_season_price" style="display: none">
                                        <td>{{ Form::text('_changeStart', null, ['class' => 'form-control datepicker have_require' , 'style' => 'width: 95%']) }}</td>
                                        <td>{{__('message.from')}} {{ Form::text('_changeEnd', null, ['class' => 'form-control datepicker have_require']) }}</td>
                                        <td>
                                            {{__('message.adult')}}
                                            {{ Form::text('_changePrice', null, ['class' => 'form-control have_require item-price']) }}
                                        </td>
                                        <td>
                                            {{__('message.child')}}
                                            {{ Form::text('_changePriceChild', null, ['class' => 'form-control have_require item-price']) }}
                                            <button type="button"class="delete_row_btn p-0">&#x2613;</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 col-form-label d-flex justify-content-end">
                                {{ Form::label('inquiry_item', __('message.inquiry_item'), array('class' => 'labelas')) }} 
                            </div>
                            <div class="col-sm-8 mt-2" >
                                <div class="custom-control custom-checkbox">
                                    {{ Form::checkbox('luggage_service', $checkbox['on'], $transport->luggage_service, array('class' => 'custom-control-input' , 'id' => "luggage_service" )) }}
                                    {{ Form::label('luggage_service', __('message.luggage_mailing_service'), array('class' => 'custom-control-label')) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-form-label d-flex justify-content-end">
                                {{ Form::label('start_date', __('message.receipt_method'), array('class' => 'labelas')) }} 
                            </div>
                            <div class="col-sm-8 mt-2">
                                <div class="custom-control custom-checkbox">
                                    {{ Form::checkbox('sent_address', $checkbox['on'], $transport->sent_address , array('class' => 'custom-control-input' , 'id' => "sent_address" )) }}
                                    {{ Form::label('sent_address', __('message.sent_address'), array('class' => 'custom-control-label')) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8 offset-sm-3" >
                                <div class="custom-control custom-checkbox">
                                    {{ Form::checkbox('e_ticket', $checkbox['on'], $transport->e_ticket, array('class' => 'custom-control-input' , 'id' => "e_ticket" )) }}
                                    {{ Form::label('e_ticket', __('message.e_ticket'), array('class' => 'custom-control-label')) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8 offset-sm-3 mt-3" >
                                <div class="custom-control custom-checkbox">
                                    {{ Form::checkbox('export_pdf', $checkbox['on'], $transport->export_pdf, array('class' => 'custom-control-input' , 'id' => "export_pdf" )) }}
                                    {{ Form::label('export_pdf', __('message.export_pdf'), array('class' => 'custom-control-label')) }}
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-sm-2 col-form-label d-flex justify-content-end">
                                {{ Form::label('status', __('message.status'), array('class' => 'labelas')) }} <span class="text-danger">*</span>
                            </div>
                            <div class="col-sm-3">
                                {{ Form::select('status', Config::get('constants.statusList') , $transport->status, ['class' => 'select2 form-control', 'required', 'placeholder' => __('message.please_select')]) }}<br/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="file-loading">
                            <input id="dataImg" type="file" name="_image[]" multiple >
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
<script src="{{asset('plugins/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('js/tinymce.js')}}"></script>
<script src="{{asset('js/fileinput.js')}}"></script>
<script src="{{ asset('js/multi_lang.js') }}"></script>
<script src="{{ asset('js/format-price.js') }}"></script>
<script src="{{ asset('js/checkbox-active.js') }}"></script>
<script>
var dataImage = @json($dataImage);
var previewConfig = @json($previewConfig);
var maxFile = {{ Config::get('constants.valid.maxFileUpload') }};
$('#dataImg').fileinput({
    maxFileCount: maxFile,
    overwriteInitial: false,
    validateInitialCount: true,
    initialPreview: dataImage,
    initialPreviewConfig: previewConfig,
});
var str_key = [];
$('#dataImg').on('filedeleted', function(event, key, jqXHR, data) {
    str_key.push(key);
    $('#_del_image').val(str_key);
});
</script>
<script>
    var count = 1;
    function addInputSeason(){
        var minPrice = {{ $minPrice }} ;
        var maxPrice = {{ $maxPrice }} ;
        var clone =  '<tr id="row-'+count+'">';
        clone += '<input name = "_idSeason['+count+']" type="hidden" >';
        clone +=  $("#clone_season_price").clone().html() + '</tr>';
        clone = clone.replace("_changeStart", "_startDate["+count+"]");
        clone = clone.replace("_changeEnd", "_endDate["+count+"]");
        clone = clone.replace("_changePrice", "_priceDate["+count+"]");
        clone = clone.replace("_changePriceChild", "_priceChildDate["+count+"]");
        $("#empty_season_price").before(clone);
        $('input[name="_startDate['+count+']"]').attr("required", "true");
        $('input[name="_endDate['+count+']"]').attr("required", "true");
        $('input[name="_priceDate['+count+']"]').attr({"required": "true", "min": minPrice, "max": maxPrice});
        $('input[name="_priceChildDate['+count+']"]').attr({"required": "true", "min": minPrice, "max": maxPrice});
        loadDatepicker();
        count++;
    }
    function addValueSeason(startDate, endDate, priceDate,priceChildDate, count , idSeason){
        var priceDate = formatPrice(priceDate);
        var priceChildDate = formatPrice(priceChildDate);
        $('input[name="_startDate['+count+']"]').val(startDate);
        $('input[name="_endDate['+count+']"]').val(endDate);
        $('input[name="_priceDate['+count+']"]').val(priceDate);
        $('input[name="_priceChildDate['+count+']"]').val(priceChildDate);
        $('input[name="_idSeason['+count+']"]').val(idSeason);
    }
    var number = 1;
    function addInputExpire(){
        var clone =  '<tr id="row-'+number+'">';
        clone +=  $("#clone_expire").clone().html() + '</tr>';
        clone = clone.replace("_changeStart", "_startDateExpire["+number+"]");
        clone = clone.replace("_changeEnd", "_endDateExpire["+number+"]");
        $("#empty_expire_date").before(clone);
        $('input[name="_startDateExpire['+number+']"]').attr("required", "true");
        $('input[name="_endDateExpire['+number+']"]').attr("required", "true");
        loadDatepicker();
        number++;
    }

    function addValueExpire(startDate, endDate, number){
        $('input[name="_startDateExpire['+number+']"]').val(startDate);
        $('input[name="_endDateExpire['+number+']"]').val(endDate);
    }
    $(document).on("click", ".delete_row_btn", function(){
        $(this).closest('tr').remove();
    });
    $(document).on('ready', function() {
        var startDate = @json(old('_startDate'));
        startDate = startDate ? startDate : @json($startDate);
        var endDate = @json(old('_endDate'));
        endDate = endDate ? endDate : @json($endDate);
        var priceDate = @json(old('_priceDate'));
        priceDate = priceDate ? priceDate : @json($priceAdult);
        var priceChildDate = @json(old('_priceChildDate'));
        priceChildDate = priceChildDate ? priceChildDate : @json($priceChild);
        var idSeason = @json($idSeason);
        if(startDate != null){
            $.each(startDate, function (index, value) {
                addInputSeason();
                addValueSeason(startDate[index], endDate[index], priceDate[index],priceChildDate[index], count-1, idSeason[index]);
            });
        }
    });
    $(document).on('ready', function() {
        var startDateExpire = @json(old('_startDateExpire'))  ;
        startDateExpire = startDateExpire ? startDateExpire : @json(array_column($expireDate, 'start_date'));
        var endDateExpire = @json(old('_endDateExpire'));
        endDateExpire = endDateExpire ? endDateExpire : @json(array_column($expireDate, 'end_date'));
        if(startDateExpire != null){
            $.each(startDateExpire, function (index, value) {
                addInputExpire();
                addValueExpire(startDateExpire[index], endDateExpire[index], number-1);
            });
        }
    });
</script>
<script>
    var optionArray = @json($optionArray);
    $( "#typeTrans" ).change(function() {
        var valueType = $(this).val();
        $("#optionTrans").empty();
        $("#optionTrans").append('<option></option>');
            if(valueType){
            $.each(optionArray[valueType], function (index, value) {
                $("#optionTrans").append('<option value='+index+'>'+value+'</option>');
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
