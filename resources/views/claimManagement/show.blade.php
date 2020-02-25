<!-- Stored in resources/views/layouts/admin/partials/top_bar_navigation.blade.php -->
@php
$sum = 0;
$totalAmount = 0;
@endphp
@extends('layouts.admin.master')
@section('title', __('message.claim_view'))
@section('stylesheets')
    <link href="{{asset('css/fileinput.css')}}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/formclaim.css')}}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/ckeditor.css')}}" media="all" rel="stylesheet" type="text/css"/>
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
                            <div class="card-body">
                                <h5 class="card-title">Request letter</h5>
                                <p class="card-text"></p>
                                {{ Form::open(array('url' => '/admin/requestLetter', 'method' => 'POST')) }}
                                    {{ Form::hidden('claim_id', $data->id ) }}

                                    {{ Form::label('letter_template_id', __('message.letter_template'), array('class' => 'labelas')) }} <span class="text-danger">*</span>
                                    {{ Form::select('letter_template_id', $listLetterTemplate, old('letter_template_id'), array('id'=>'code_claim', 'class' => 'select2 form-control', 'required')) }}
                                    {{ Form::submit( 'Send Letter', ['class' => 'mt-3 btn btn-info']) }}

                                {{ Form::close() }}
                
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
                            <th>Create By</th>
                            <th>Current Status</th>
                            <th>Change Status</th>
                            <th>Note</th>
                            <th>Wait for the check</th>
                            
                            <th class='text-center'>{{ __('message.control')}}</th>
                        </tr>
                    </thead>
                    
                    @foreach ($data->export_letter as $item)
                        <tr id="empty_item" >
                            <td>{{$item->id}}</td>
                            <td>{{$item->letter_template->name}}</td>
                            <td>
                                <h6>{{$item->userCreated->name}}</h6>
                                <span>{{ $item->created_at }}</span>
                            </td>
                            <td>
                                <h5 class="p-0 text-primary">{{ data_get($list_status_ad,  $item->status ,'New') }} </h5>
                            </td>
                            <td>
                                {{ Form::open(array('url' => '/admin/changeStatus', 'method' => 'POST', 'class' => 'form-inline')) }}
                                    <div>
                                        {{ Form::hidden('id', $item->id) }}
                                        {{ Form::hidden('claim_id', $item->claim_id) }}
                                        {{ Form::select('status', $item->list_status, null, [ 'class' => 'form-control col-md-8', 'placeholder' => 'Select Option']) }}
                                        {!! Form::button('submit', ['type' => 'submit', 'class' => 'pull-right btn btn-info btn-md col-md-4']) !!}
                                    </div>
                                {!! Form::close() !!}
                            </td>
                            <td>
                                @foreach ($item->note as $note)
                                    <div class="form-group">
                                        {!! Form::button('<i class="fa fa-commenting"></i>' . $admin_list[$note['user']], ['data-toggle' => "modal" ,  
                                        'data-target' => "#noteModal",
                                        'type' => 'button', 
                                        'class' => 'btn btn-danger btn-xs' , 
                                        'onclick' => 'note(this);',
                                        'data-claim_id' => $data->id,
                                        'data-note' => $note['data'],
                                        'data-status' => $item->status,
                                        'data-id' => $item->id
                                        ]) !!}
                                        <br>
                                        {{$note['created_at']}}
                                    </div>
                                @endforeach
                            </td>
                            <td>
                                @if (isset($item->wait['data']))                                
                                        {!! Form::button('<i class="fa fa-commenting"></i>' . $admin_list[$item->wait['user']], ['data-toggle' => "modal" ,  
                                        'data-target' => "#noteModal",
                                        'type' => 'button', 
                                        'class' => 'btn btn-success btn-xs' , 
                                        'onclick' => 'note(this);',
                                        'data-claim_id' => $data->id,
                                        'data-note' => $item->wait['data'],
                                        'data-status' => $item->status,
                                        'data-id' => $item->id
                                        ]) !!}
                                        <br>
                                        {{$item->wait['created_at']}}
                                @endif
                            </td>
                            <td>
                                {{ Form::open(array('url' => '/admin/exportLetter', 'method' => 'POST')) }}
                                    {{ Form::hidden('claim_id', $data->id ) }}
                                    {{ Form::hidden('letter_template_id', $item->letter_template->id ) }}
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
                            </td>
                        </tr>
                    @endforeach
                </table>
                

                {{-- //calculate --}}
                @foreach ($items as $data)
                    @php
                        if($data->reason_reject_id){
                            $sum += removeFormatPrice($data->amount);
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
                        
                        
                            @foreach ($items as $data)
                            <tr>
                                <td>{{$data->content}}</td>
                                <td>{{$data->amount}}</td>
                                @php
                                    $totalAmount += removeFormatPrice($data->amount);
                                @endphp
                                <td>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input " disabled readonly {{ $data->reason_reject_id ? "" : 'checked' }}>
                                        <span class="custom-control-indicator"></span>
                                    </label>
                                </td>
                                <td>
                                    @if($data->reason_reject_id)
                                        <p class="text-danger font-weight-bold">{{ $data->reason_reject->name}}</p>
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
                    
                        <button class="btn btn-danger">{{ __('message.yes')}} </button>
                        <button type="button" class="btn btn-secondary btn-cancel-delete" 
                            data-dismiss="modal">{{ __('message.no') }}</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

{{-- Modal note--}}
<div id="noteModal" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            {{ Form::open(array('url' => '/admin/waitCheck', 'method' => 'POST')) }}
                {{ Form::hidden('id', null ,['class' => 'export_letter_id']) }}
                {{ Form::hidden('claim_id', null ,['class' => 'ex_claim_id']) }}

                <div class="modal-header">
                    <h4 class="modal-title">Note</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    {{ Form::textarea('template', old('template'), ['id' => 'note_letter', 'class' => 'form-control editor_default']) }}<br>
                </div>
                <div class="modal-footer">
                   {{ Form::select('status', config('constants.statusExportText'), null, [ 'class' => 'status_letter form-control editor_default', ]) }}<br>
                    
                        <button class="btn btn-danger">{{ __('message.yes')}} </button> 
                        <button type="button" class="btn btn-secondary btn-cancel-delete" 
                            data-dismiss="modal">{{ __('message.no') }}</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
    
{{-- Modal approved--}}
<div id="approvedModal" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            {{ Form::open(array('url' => '/admin/changeStatus', 'method' => 'POST')) }}
                {{ Form::hidden('id', null ,['class' => 'export_letter_id']) }}
                {{ Form::hidden('claim_id', null ,['class' => 'ex_claim_id']) }}

                <div class="modal-header">
                    <h4 class="modal-title">Approve</h4>
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



@endsection


@section('scripts')
<script src="{{asset('js/fileinput.js')}}"></script>
<script src="{{ asset('js/format-price.js') }}"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{asset('js/popper.min.js')}}" ></script>
<script src="{{ asset('plugins/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('js/tinymce.js') }}"></script>
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
        data: {'claim_id' : claim_id , 'letter_template_id' : letter_template_id },
        })
        .done(function(res) {
            tinymce.get("preview_letter").setContent(res);
            //CKEDITOR.instances['preview_letter'].setData(res);
            $(".loader").fadeOut("slow");
        })
    }

    function note(e){
        var claim_id =  e.dataset.claim_id;
        var letter_template_id = e.dataset.letter_template_id;
        var status = e.dataset.status;
        var id = e.dataset.id;
        var note = e.dataset.note;
        $('.status_letter').val(status).change();
        $('.export_letter_id').val(id);
        $('.ex_claim_id').val(claim_id);
        
        tinymce.get("note_letter").setContent(note);
        //CKEDITOR.instances['note_letter'].setData(note);
    }

    function approved(e){
        
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

    function addNote(e){
        var id = e.dataset.id;
        var claim_id =  e.dataset.claim_id;
        $('.export_letter_id').val(id);
        $('.ex_claim_id').val(claim_id);
    
    }
</script>
@endsection
