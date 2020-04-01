<!-- Stored in resources/views/layouts/admin/partials/top_bar_navigation.blade.php -->
@php
$sum = 0;
$totalAmount = 0;
@endphp
@extends('layouts.admin.master')
@section('title', __('message.claim_view'))
@section('stylesheets')
    <link href="{{asset('css/fileinput.css?vision=') .$vision }}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/formclaim.css?vision=') .$vision }}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/ckeditor.css?vision=') .$vision }}" media="all" rel="stylesheet" type="text/css"/>
    <style>
        .disableRow {
            background-color: lightslategrey;
        }
    </style>
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
                        <div class="card">
                            <div class="card-body row">
                                <div class="col-md-6">
                                    <h5 class="card-title">Request Letter</h5>
                                    <p class="card-text"></p>
                                    {{ Form::open(array('url' => '/admin/requestLetter', 'method' => 'POST')) }}
                                        {{ Form::hidden('claim_id', $data->id ) }}

                                        {{ Form::label('letter_template_id', __('message.letter_template'), array('class' => 'labelas')) }} <span class="text-danger">*</span>
                                        {{ Form::select('letter_template_id', $listLetterTemplate, old('letter_template_id'), array('id'=>'letterTemplate', 'class' => 'select2 form-control', 'required')) }}
                                        {!! Form::button('Send Letter', ['data-toggle' => "modal" ,  
                                            'data-target' => "#comfirmPaymentModal",
                                            'type' => 'button', 
                                            'class' => 'mt-3 btn btn-info' , 
                                            'onclick' => 'comfirmPayment(this);',
                                            ]) !!}
                                    {{ Form::close() }}
                                </div>
                                <div class="col-md-6">
                                    <h5 class="card-title">Claim Word Sheet</h5>
                                    @if($data->claim_word_sheet)
                                    <a target="_blank" href="{{route('claimWordSheets.show', ['claimWordSheet' => $data->claim_word_sheet->id])}}" class="mt-3 btn btn-info">Link Work Sheet</a>
                                    @else
                                        
                                        {{ Form::open(array('url' => route('claimWordSheets.store'))) }}
                                        {{ Form::hidden('claim_id', $data->id ) }}
                                        {{ Form::hidden('mem_ref_no', $data->clClaim->member->memb_ref_no ) }}
                                        <button class="btn btn-info" type="submit" value="save">Run</button> 
                                        {{ Form::close() }}
                                    @endif
                                </div>  
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            {{ Form::label('type',  __('message.id_claim'), array('class' => 'col-md-4')) }}
                            {{ Form::label('type', $data->code_claim , array('class' => 'col-md-8')) }}

                            {{ Form::label('type',  'Claim Code', array('class' => 'col-md-4')) }}
                            {{ Form::label('type', $data->code_claim_show , array('class' => 'col-md-8')) }}

                            {{ Form::label('type',  'Barcode', array('class' => 'col-md-4')) }}
                            {{ Form::label('type', $data->barcode , array('class' => 'col-md-8')) }}

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
                <div class="d-flex justify-content-center mt-3">
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
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name Letter</th>
                            <th>Info</th>
                            <th>Create By</th>
                            <th>Current Status</th>
                            <th>History</th>
                            <th>Note</th>
                            <th>Wait for the check</th>
                            
                            <th class='text-center'>{{ __('message.control')}}</th>
                        </tr>
                    </thead>
                    
                    @foreach ($data->export_letter as $item)
                        <tr class = "{{isset($item->info['note']) ? "disableRow" : ""}} " >
                            <td>{{$item->id}}</td>
                            <td>
                                {{$item->letter_template->name}}
                                @if($item->status == $item->end_status && !isset($item->info['note']) && $item->created_user == $user->id )
                                {{ Form::open(array('url' => '/admin/sendEtalk', 'method' => 'POST', 'class' => 'form-inline')) }}
                                    <div>
                                        {{ Form::hidden('id', $item->id) }}
                                        {{ Form::hidden('barcode', $data->barcode) }}
                                        {{ Form::hidden('claim_id', $item->claim_id) }}
                                        
                                        {!! Form::button('Send Etalk', 
                                        [   'type' => 'submit', 
                                            'class' => 'btn btn-info btn-md' ,
                                            'onclick'=> 'clickSendEtalk(this)',
                                            'data-url' => config("constants.url_cps").$data->barcode
                                        ]) !!}
                                    </div>
                                {!! Form::close() !!}
                                @endif

                                @if(isset($item->info['note']))
                                    <h6> Added on Etalk</h6>
                                    <span>Note Id : {{data_get($item->info, "note.id")}}</span><br>
                                    <a class="btn btn-success btn-xs" href="{{config("constants.url_cps").$data->barcode}}" target="_blank">Link CPS</a>
                                @endif
                            </td>
                            <td>
                                <p  class = "m-0">Approve AMT : </p> 
                                <span class="p-1 mb-2 bg-danger text-white   align-middle">{{formatPrice(data_get($item->info,'approve_amt'), ' đ')}} </span>
                                <p class = "m-0">End Status :  </p> 
                                <span class="p-1 mb-2 bg-info text-white  align-middle">{{data_get($list_status_ad, $item->end_status)}}</span>
                            </td>
                            <td>
                                <h6>{{$item->userCreated->name}}</h6>
                                <span>{{ $item->created_at }}</span>
                            </td>
                            <td>
                                <h5 class="p-0 text-primary">{{ data_get($list_status_ad,  $item->status ,'New') }} </h5>
                            </td>
                            <td>
                                {{-- history --}}
                                @include('history',[
                                    'idmodal' => 'items_'.$item->id,
                                    'log_history' => $item->log
                                ])
                            </td>
                            <td>
                                <button href="#collapse{{$item->id}}" class="nav-toggle btn btn-info pull-right p-1">▲</button>
                                @for ($i = count($item->note)-1; $i >= 0 ; $i--)
                                    @if($i == count($item->note)-2)
                                    <div id="collapse{{$item->id}}" style="display:none">
                                    @endif
                                    <div class="form-group">
                                        {!! Form::button('<i class="fa fa-commenting"></i>' . $admin_list[$item->note[$i]['user']], ['data-toggle' => "modal" ,  
                                        'data-target' => "#viewFileModal",
                                        'type' => 'button', 
                                        'class' => 'btn btn-danger btn-xs' , 
                                        'onclick' => 'viewFile(this);',
                                        'data-claim_id' => $data->id,
                                        'data-note' => $item->note[$i]['data'],
                                        'data-status' => $item->status,
                                        'data-id' => $item->id
                                        ]) !!}
                                        <br>
                                        {{$item->note[$i]['created_at']}}
                                    </div>
                                    @if($i == 0)
                                    </div>
                                    @endif
                                @endfor
                            </td>
                            <td>
                                @if (isset($item->wait['data']))                                
                                        {!! Form::button('<i class="fa fa-commenting"></i>' . $admin_list[$item->wait['user']], ['data-toggle' => "modal" ,  
                                        'data-target' => "#noteOrEditModal",
                                        'type' => 'button', 
                                        'class' => 'btn btn-success btn-xs' , 
                                        'onclick' => 'noteOrEdit(this);',
                                        'data-claim_id' => $data->id,
                                        'data-note' => $item->wait['data'],
                                        'data-status' => $item->created_user == $user->id ? config('constants.statusExport.edit') : config('constants.statusExport.note_save'),
                                        'data-id' => $item->id,
                                        'data-liststatus' => json_encode($item->list_status)
                                        ]) !!}
                                        <br>
                                        {{$item->wait['created_at']}}
                                @endif
                            </td>
                            <td>
                                {{ Form::open(array('url' => '/admin/exportLetter', 'method' => 'POST')) }}
                                @csrf
                                    {{ Form::hidden('claim_id', $data->id ) }}
                                    {{ Form::hidden('letter_template_id', $item->letter_template->id ) }}
                                    {{ Form::hidden('export_letter_id', $item->id ) }}
                                <div class='btn-group'>
                                    {!! Form::button('<i class="fa fa-eye-slash"></i>', ['data-toggle' => "modal" ,  
                                        'data-target' => "#previewModal",
                                        'type' => 'button', 
                                        'class' => 'btn btn-success btn-xs' , 
                                        'onclick' => 'preview(this);',
                                        'data-claim_id' => $data->id,
                                        'data-letter_template_id' => $item->letter_template->id,
                                        'data-status' => $item->status,
                                        'data-id' => $item->id
                                        ]) 
                                    !!}
                                    {!! Form::button('<i class="fa fa-print"></i>', ['type' => 'submit', 'class' => 'btn btn-info btn-xs']) !!}
                                </div>
                                {!! Form::close() !!}
                                {{-- btn letter payment --}}
                                @if ($item->letter_template->letter_payment != null)
                                    {{ Form::open(array('url' => '/admin/exportLetterPDF', 'method' => 'POST')) }}
                                    @csrf
                                        {{ Form::hidden('claim_id', $data->id ) }}
                                        {{ Form::hidden('export_letter_id', $item->id ) }}
                                        {{ Form::hidden('letter_template_id', $item->letter_template->letter_payment ) }}
                                        {{ Form::hidden('id', $item->id ) }}
                                        {!! Form::button('<i class="fa fa-file-pdf-o"></i>', ['type' => 'submit', 'class' => 'btn btn-info btn-xs']) !!}
                                    {!! Form::close() !!} 
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
                

                {{-- //calculate --}}
                @foreach ($items as $item)
                    @php
                        if($item->reason_reject_id){
                            $sum += removeFormatPrice($item->amount);
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
                        
                        
                            @foreach ($items as $item)
                            <tr>
                                <td>{{$item->content}}</td>
                                <td>{{$item->amount}}</td>
                                @php
                                    $totalAmount += removeFormatPrice($item->amount);
                                @endphp
                                <td>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input " disabled readonly {{ $item->reason_reject_id ? "" : 'checked' }}>
                                        <span class="custom-control-indicator"></span>
                                    </label>
                                </td>
                                <td>
                                    @if($item->reason_reject_id)
                                        <p class="text-danger font-weight-bold">{{ $item->reason_reject->name}}</p>
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

{{-- Modal preview--}}
<div id="previewModal" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            {{ Form::open(array('url' => '/admin/waitCheck', 'method' => 'POST')) }}
                {{ Form::hidden('id', null ,['class' => 'export_letter_id']) }}
                {{ Form::hidden('claim_id', null ,['class' => 'ex_claim_id']) }}

                <div class="modal-header">
                    <h4 class="modal-title">Preview</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    {{ Form::textarea('template', old('template'), ['id' => 'preview_letter', 'class' => 'form-control editor_default']) }}<br>
                </div>
                <div class="modal-footer">
                    {{ Form::hidden('status', config('constants.statusExport.new')) }}<br>
                    
                        <button class="btn btn-danger" name="save_letter" value="save">{{ __('message.yes')}} </button>
                        <button type="button" class="btn btn-secondary btn-cancel-delete" 
                            data-dismiss="modal">{{ __('message.no') }}</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

{{-- noteOrEditModal--}}
<div id="noteOrEditModal" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            {{ Form::open(array('url' => '/admin/waitCheck', 'method' => 'POST')) }}
                {{ Form::hidden('id', null ,['class' => 'export_letter_id']) }}
                {{ Form::hidden('claim_id', null ,['class' => 'ex_claim_id']) }}

                <div class="modal-header">
                    <h4 class="modal-title">Note of Reject </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    {{ Form::textarea('template', old('template'), ['id' => 'note_letter', 'class' => 'form-control editor_default']) }}<br>
                    {{ Form::hidden('status', config('constants.statusExport.note_save'), ['id' => 'statusSubmit']) }}<br>
                    <div class="row">
                        <div id = 'button_save' class="pull-right">
                            <button class="btn btn-danger" name="save_letter" value="save"> Save Letter</button> 
                            <button type="button" class="btn btn-secondary btn-cancel-delete" 
                                data-dismiss="modal">Close</button>
                        </div><br>
                    </div>
                    
                </div>
                <div class="modal-footer bg-info">
                    <h4 class="modal-title"> Change Status </h4>
                    <div id='button_items'>
                    </div>
                    <div id="button_clone" style="display: none">
                        <button class="btn btn-secondary m-1" name = 'status_change' value = 'value_default'> text_default </button> 
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
    
{{-- Modal viewFile--}}
<div id="viewFileModal" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        
        <!-- Modal content-->
        <div class="modal-content">
            {{ Form::open(array('url' => '/admin/changeStatus', 'method' => 'POST')) }}
                {{ Form::hidden('id', null ,['class' => 'export_letter_id']) }}
                {{ Form::hidden('claim_id', null ,['class' => 'ex_claim_id']) }}

                <div class="modal-header">
                    <h4 class="modal-title">View</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    {{ Form::textarea('template', old('template'), ['id' => 'approve_letter', 'class' => 'form-control editor_default']) }}<br>
                </div>
                <div class="modal-footer">
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

{{-- Modal comfirm payment--}}
<div id="comfirmPaymentModal" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Comfirm Letter </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {{ Form::open(array('url' => '/admin/requestLetter', 'method' => 'POST')) }}
                    {{ Form::hidden('claim_id', $data->id ) }}
                    {{ Form::hidden('letter_template_id', null, array('id'=>'LetterTemplateId', 'class' => 'form-control')) }}

                    {{ Form::text(null, null, array('id' => 'textLetter','class' => 'form-control', 'readonly')) }}<br>

                    
                    {{-- HBS --}}
                    <div class="row mb-2">
                        {{ Form::label('type',  'Apr Amt HBS' , array('class' => 'col-md-2')) }} 
                        {{ Form::text('apv_hbs', null , array('id' => 'apv_hbs_in','class' => 'col-md-4 item-price form-control', 'readonly')) }}
                    </div>
                    {{-- mantis --}}
                    <div class="row  mb-2">
                        {{ Form::label('type',  'Payment History' , array('class' => 'col-md-2')) }} 
                        <table id="season_price_tbl" class="table table-striped header-fixed col-md-8">
                            <thead>
                                <tr>
                                    <th>Datetime</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="empty_item" style="display: none;">
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr id="clone_item" style="display: none;">
                                    <td>_text_default</td>
                                    <td>
                                        {{ Form::text('_amount_default', '_amount_value_default', ['class' => 'item-price form-control p-1 history_amt' , 'readonly']) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    {{-- Cấn trừ --}}
                    <div class="row mb-2">
                        {{ Form::label('PCV_EXPENSE',  'PCV EXPENSE' , array('class' => 'col-md-2')) }}
                        {{ Form::text('PCV_EXPENSE', null , array('id' => 'PCV_EXPENSE','class' => 'col-md-4 item-price form-control', 'readonly' ,'onchange' => "amount_letter_print()")) }}
                    </div>
                    <div class="row mb-2">
                        {{ Form::label('type',  'DEBT BALANCE' , array('class' => 'col-md-2')) }}
                        {{ Form::text('DEBT_BALANCE', null , array('id' => 'DEBT_BALANCE','class' => 'col-md-4 item-price form-control', 'readonly' ,'onchange' => "amount_letter_print()")) }}
                    </div>
                    <a class="btn btn-success btn-xs" href="{{config("constants.url_cps").$data->barcode}}" target="_blank">Link CPS</a>
                    <button type="button" class="btn btn-primary" onclick="comfirmPayment()"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                    {{-- Print letter --}}
                    <div class="row mb-2">
                        {{ Form::label('type',  'Amount in Payment Letter' , array('class' => 'text-white col-md-4 bg-secondary')) }} 
                        {{ Form::text('amount_letter', null , array('id' => 'amount_letter','class' => 'h5 text-danger col-md-4 bg-secondary item-price', 'readonly' )) }}
                    </div>
                    <div class="row">
                        <div id = 'button_save' class="pull-right">
                            <button class="btn btn-danger" name="save_letter" value="save"> OK</button> 
                            <button type="button" class="btn btn-secondary btn-cancel-delete" 
                                data-dismiss="modal">Close</button>
                        </div><br>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script src="{{asset('js/fileinput.js?vision=') .$vision }}"></script>
<script src="{{ asset('js/format-price.js?vision=') .$vision }}"></script>
<script src="{{ asset('js/jquery-ui.js?vision=') .$vision }}"></script>
<script src="{{asset('js/popper.min.js?vision=') .$vision }}" ></script>

<script src="{{ asset('js/tinymce.js?vision=') .$vision }}"></script>
<script>
    function preview(e){
        $(".loader").show();
        var claim_id =  e.dataset.claim_id;
        var letter_template_id = e.dataset.letter_template_id;
        var status = e.dataset.status;
        var id = e.dataset.id;
        $('.status_letter').val(status).change();
        $('.export_letter_id').val(id);
        $('.ex_claim_id').val(claim_id);
        tinymce.get("preview_letter").setContent("");
        //CKEDITOR.instances['preview_letter'].setData("");
        $.ajax({
        url: '/admin/previewLetter',
        type: 'POST',
        context: e,
        data: {'claim_id' : claim_id , 'letter_template_id' : letter_template_id , 'export_letter_id' : id},
        })
        .done(function(res) {
            tinymce.get("preview_letter").setContent(res);
            //CKEDITOR.instances['preview_letter'].setData(res);
            $(".loader").fadeOut("slow");
        })
    }

    function noteOrEdit(e){
        var claim_id =  e.dataset.claim_id;
        var letter_template_id = e.dataset.letter_template_id;
        var status = e.dataset.status;
        var id = e.dataset.id;
        var note = e.dataset.note;
        var list_status = e.dataset.liststatus;
        if(status == {{ config('constants.statusExport.edit')}}){
            $('#button_save').show();
        }else{
            $('#button_save').hide();
        }
        $('.export_letter_id').val(id);
        $('.ex_claim_id').val(claim_id);
        $("#button_items").empty();
        $.each(JSON.parse(list_status), function( index, value ) {
            var res = value.match(/(Rejected)|(rejected)/g);
            if(res){
                addButton(index,value,'rejected');
            }else{
                var res2 = value.match(/(Approved)|(approved)/g);
                if(res2){
                    addButton(index,value,'approved');
                }else{
                addButton(index,value);
                }
            }
        });

        
        tinymce.get("note_letter").setContent(note);
        //CKEDITOR.instances['note_letter'].setData(note);
    }

    function addButton(value,text, type = 'none'){
        clone =  $("#button_clone").clone().html() ;
        
        clone = clone.replace("text_default", text);
        if(type == 'rejected'){
            clone = clone.replace("btn-secondary", 'btn-danger');
            clone = clone.replace("value_default", value+"-"+type);
        }else{
            clone = clone.replace("value_default", value+"-"+type);
        }
        $("#button_items").append(clone);
    }

    function viewFile(e){
        
        var claim_id =  e.dataset.claim_id;
        var letter_template_id = e.dataset.letter_template_id;
        var status = e.dataset.status;
        var id = e.dataset.id;
        var note = e.dataset.note;
        $('.status_letter').val(status).change();
        $('.export_letter_id').val(id);
        $('.ex_claim_id').val(claim_id);
        
        tinymce.get("approve_letter").setContent(note);
        //CKEDITOR.instances['approve_letter'].setData(note);
    }

    function comfirmPayment(e){
        $('.loader').show();
        var letter_template_id  = $("#letterTemplate option:selected").val();
        var letter_template_name  = $("#letterTemplate option:selected").text();
        $('#LetterTemplateId').val(letter_template_id);
        $("#textLetter").val(letter_template_name);
        $(".h_payment").remove();

        axios.get("{{ url('admin/getPaymentHistoryCPS') }}/{{$data->code_claim_show}}")
        .then(function (response) {
            $.each( response.data.data, function( key, value ) {
                addInputItem("Lần " + value.PAYMENT_TIME +". " + value.TF_DATE , formatPrice(value.TF_AMT));
            });
            $('#apv_hbs_in').val(formatPrice(response.data.approve_amt));
            //get info balance
            axios.get("{{ url('admin/getBalanceCPS') }}/{{$data->clClaim->member->memb_ref_no}}/{{$data->code_claim_show}}")
            .then(response => { 
                console.log(response.data);
                $('#PCV_EXPENSE').val(formatPrice(response.data.data.PCV_EXPENSE));
                $('#DEBT_BALANCE').val(formatPrice(response.data.data.DEBT_BALANCE));
            });

            $(".loader").fadeOut("slow");
            amount_letter_print();
        })
        .catch(function (error) {
            $(".loader").fadeOut("slow");
            alert(error);
            
        });
        
    }
    function addInputItem(text,amt){

        let clone =  '<tr class = "h_payment">' + $("#clone_item").clone().html() + '</tr>';
        //repalace name
        clone = clone.replace("_text_default", text);
        clone = clone.replace("_amount_default", "amount[]");
        clone = clone.replace("_amount_value_default", amt);
        $("#empty_item").before(clone);
        
    }
    function amount_letter_print(){
        var total = 0;
        var hbs_amt = parseInt(removeFormatPrice($('#apv_hbs_in').val()));
        var deduct = parseInt(removeFormatPrice($("#deduct").val() ? $("#deduct").val() : 0));
        var sumhis = 0;
        $(".history_amt").each(function( index ) {
            sumhis += parseInt(removeFormatPrice( $(this).val() ? $(this).val() : 0 )) ;
        });
        if($(".btn-method").text() == '+'){
            $('#amount_letter').val(formatPrice(hbs_amt + deduct - sumhis));
        }else{
            $('#amount_letter').val(formatPrice(hbs_amt - deduct - sumhis));
        }
        
    }
    function addNote(e){
        var id = e.dataset.id;
        var claim_id =  e.dataset.claim_id;
        $('.export_letter_id').val(id);
        $('.ex_claim_id').val(claim_id);
    
    }

    $(".disableRow").find("input,textarea,select").attr("disabled", "disabled");

    function clickSendEtalk(e){
        var url = e.dataset.url;
        window.open(url);
    }

    $(document).ready(function () {
        $('.nav-toggle').click(function () {
            var collapse_content_selector = $(this).attr('href');
            var toggle_switch = $(this);
            $(collapse_content_selector).toggle(function () {
                if ($(this).css('display') == 'none') {
                    toggle_switch.html('▲');
                } else {
                    toggle_switch.html('▼');
                }
            });
        });

        $('.btn-method').click(function () {
            if($(this).text() == '+'){
                $(this).html('-')
            }else{
                $(this).html('+')
            }
            amount_letter_print();
        });
    });
</script>
@endsection
