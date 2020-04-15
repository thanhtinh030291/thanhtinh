<h3 class="text-center">Claim Work Sheet</h3>
<div style="position: absolute; right: 5px; top: 0px;">
    <table class="table table-striped" style="width: 120px">
        <thead>
            <tr>
                <th>
                    DLVN Claim
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    {{$claim->barcode}}
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="row mt-5">
    <div class="col-md-4">
    <p class="font-weight-bold">Name: {{$member->mbr_last_name ." " . $member->mbr_first_name}}</p>
    </div>
    <div class="col-md-4">
    <p class="font-weight-bold">DOB: {{ Carbon\Carbon::parse($member->dob)->format('d/m/Y') }}</p>
    </div>
    <div class="col-md-4">
    <p class="font-weight-bold">Sex: {{str_replace("SEX_", "",$member->scma_oid_sex)}}</p>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
    <p class="font-weight-bold">Policy No: {{$HBS_CL_CLAIM->Police->pocy_ref_no}}</p>
    </div>
    <div class="col-md-4">
    <p class="font-weight-bold">Member No: {{ $member->memb_ref_no}}</p>
    </div>
    <div class="col-md-4">
    <p class="font-weight-bold">Claim No.: {{$claim->code_claim_show}}</p>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
    <p class="font-weight-bold">Effective date: {{$member->pocyEffdate}}</p>
    </div>
    <div class="col-md-6">
    <p class="font-weight-bold">Status:  
        {!! Form::textarea('status_online_query', $claimWordSheet->status_online_query ? $claimWordSheet->status_online_query : $member->statusQuery,['class' => 'editor_not_menu' , 'rows' => "3"]) !!}
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#onlineQueryModal">
            Online Query
        </button>
    </p>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <p class="font-weight-bold">Plan: </p>
        <div class="ml-5">
            @foreach ($member->plan as $item)
                <p>{{$item}}</p>
            @endforeach
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-check form-check-inline">
            {{ Form::hidden('30_day', '0')}}
            {{ Form::checkbox('30_day', '1', $claimWordSheet['30_day'] == 1? true : false , ['class' => 'form-check-input'])}}
            <label class="form-check-label" for="inlineCheckbox1">- 30 ngày chờ</label>
        </div><br>
        <div class="form-check form-check-inline">
            {{ Form::hidden('1_year', '0')}}
            {{ Form::checkbox('1_year', '1', $claimWordSheet['1_year'] == 1? true : false , ['class' => 'form-check-input'])}}
            <label class="form-check-label" for="inlineCheckbox1">- 1 năm chờ</label>
        </div><br>
        <div class="form-check form-check-inline">
            {{ Form::hidden('contract_rule', '0')}}
            {{ Form::checkbox('contract_rule', '1', $claimWordSheet['contract_rule'] == 1? true : false , ['class' => 'form-check-input'])}}
            <label class="form-check-label" for="inlineCheckbox1">- Hợp đồng/Điều khoản</label>
        </div>
        
    </div>
</div>
<div>
    <p class="font-weight-bold">Occupation Loading: 
        @foreach ($member->occupation as $item)
            <span class="ml-3">{{$item}}</span>
        @endforeach
    </p>
    <p><span  class="font-weight-bold">Loading:</span> 
        {{$member->MR_MEMBER_EVENT->where('scma_oid_event_code', 'EVENT_CODE_EXPL')->first() ? $member->MR_MEMBER_EVENT->where('scma_oid_event_code', 'EVENT_CODE_EXPL')->first()->event_desc : "" }}
    </p>
    <p><span  class="font-weight-bold">Exclusion:</span> 
        {{$member->MR_MEMBER_EVENT->where('scma_oid_event_code', 'EVENT_CODE_EXCL')->first() ? $member->MR_MEMBER_EVENT->where('scma_oid_event_code', 'EVENT_CODE_EXCL')->first()->event_desc : ""}}
    </p>
    <p><span  class="font-weight-bold">Etalk Link:</span>
        <a class="btn btn-primary" target="_blank" href="{{config('constants.url_mantic').'view.php?id='.$claim->barcode }}">Link</a>
    </p>
</div>

<div class="row">
    <div class="col-sm-2 col-form-label ">
        <p class="font-weight-bold"><span>Type of visit: IP / OP  </span><button type="button" id="add_button_type_of_visit">Add Field</button></p>
    </div>
</div>
<div id="type_of_visit">

</div>
<div class="input_fields_type_of_visit  ml-4" style="display:none">
    <div class = "row mt-2">
        <div class="col-3 input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">Incur date: From</div>
            </div>
            {{ Form::text('_type_of_visit[from]', '' , ['class'=>"imask-input form-control col"]) }}
        </div>
        <div class="col-2 input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">To</div>
            </div>
            {{ Form::text('_type_of_visit[to]', '' , ['class'=>"imask-input form-control col"]) }}
        </div>
        <div class="col-6 input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">Diagnosis: </div>
            </div>
            {{ Form::text('_type_of_visit[diagnosis]', '' , ['class'=>"form-control col"]) }}
        </div>
        <button type="button" class="col-1 btn btn-danger remove_field_btn" >X</button>
    </div>
</div>

<div>
    <p class="font-weight-bold">CLAIM HISTORY</p>
    <table class="table table-striped header-fixed w-75">
        <thead>
            <th>Date</th>
            <th>Diagnosis</th>
            <th>Treatment</th>
            <th>Claim result(Approved)</th>
        </thead>
        <tbody>
            @if(!empty($claim_line))
            @foreach ($claim_line as $item)
                <tr>
                    <td>{{Carbon\Carbon::parse($item->incur_date_from)->format('d/m/Y') .' - '.Carbon\Carbon::parse($item->incur_date_to)->format('d/m/Y')}}</td>
                    <td>{{$item->RT_DIAGNOSIS->diag_desc_vn}}</td>
                    <td>{{str_replace("BENEFIT_TYPE_", "", $item->PD_BEN_HEAD->scma_oid_ben_type)}} - {{$item->PD_BEN_HEAD->ben_head}} </td>
                    <td>{{formatPrice($item->app_amt)}}</td>
                </tr>
            @endforeach
            @endif
                
        </tbody>
    </table>
</div>

<div>
    <p class="font-weight-bold">MEMBER CLAIM EVENT</p>
    <table class="table table-striped header-fixed w-75">
        <thead>
            <th>Date</th>
            <th>Description</th>
        </thead>
        <tbody>
            @if(!empty($member->CL_MBR_EVENT))
                @foreach ($member->CL_MBR_EVENT as $item)
                    <tr>
                        <td>{{Carbon\Carbon::parse($item->eff_date)->format('d/m/Y')}}</td>
                        <td>{{$item->event_desc}}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

<div>
    <p class="font-weight-bold">CLAIM ASSESSMENT</p>
    <div class="row ml-1">
        <div class="col-md-4">
            <h6>BENEFIT  <button class="add_benefit_button">Add Benefit</button></h6>
            <div id="field_benefit">

            </div>
            <div id="clone_benefit" style="display: none">
                <div class = "row mt-2">
                    <div class="col-sm-6">
                        {{ Form::select('_benefit[content]', config('constants.benefit'),null, ['class'=>" _select2 form-control " ]) }}
                    </div>
                    {{ Form::text('_benefit[amount]', null, ['class'=>"item-price form-control col-sm-5 benefit_input", 'onchange' => 'add_amt()']) }}
                    <button type="button" class="col-md-1 remove_field_btn btn btn-danger">X</>
                </div>
            </div>
            
        </div>
        <div class="col-md-12 mt-2">
            <h6>REJECT  <button type="button" class="" onclick="addInputItem()">Add Reject</button></h6>
            @include('layouts.admin.form_reject')
                
        </div>
    </div>
    <div class="row ml-1">
        <div class="col-md-6">
            CLAIM AMT {{ Form::text('claim_amt', $claimWordSheet->claim_amt, [ 'id' => 'claim_amt' ,'class'=>"item-price form-control col-sm-5", 'readonly']) }}
        </div>
        <div class="col-md-6">
            PAYABLE AMT {{ Form::text('payable_amt', $claimWordSheet->payable_amt, ['id' => 'payable_amt' ,'class'=>"item-price form-control col-sm-5", 'readonly']) }}
        </div>
    </div>
    
    {!! Form::textarea('assessment', $claimWordSheet->assessment,['class' => 'editor_default2' , 'rows' => "4"]) !!}
</div><br>

<div>
    <p class="font-weight-bold">MEDICAL OPINIONS  <button class="add_field_button">Add Question</button></p>
    <div class="input_fields_wrap w-75 ml-4">
        @foreach ($claimWordSheet->request_qa as $item)
        <div class = "row mt-2">
            
            {{ Form::text('request_qa[]', $item , ['class'=>"form-control col-md-11"]) }}
            <button type="button" class="col-md-1 remove_field_btn btn btn-danger">X</button>
        </div>
        @endforeach
        
        
    </div><br>
    {!! Form::textarea('medical', $claimWordSheet->medical,[
        'class' => Auth::user()->hasRole('Medical') ?  'editor_default2' : 'editor_readonly' , 
        'rows' => "4" ]) !!}
</div><br>

<div>
    <p class="font-weight-bold">CLAIM RESULT</p>
    <div class="form-check form-check-inline">
        {{ Form::radio('claim_resuft', '1' , $claimWordSheet->claim_resuft == 1 ? true : false) }}
        <label class="form-check-label" for="inlineRadio1">{{config("constants.claim_result.1")}}</label>
    </div>
    <div class="form-check form-check-inline">
        {{ Form::radio('claim_resuft', '2' , $claimWordSheet->claim_resuft == 2 ? true : false) }}
        <label class="form-check-label" for="inlineRadio2">{{config("constants.claim_result.2")}}</label>
    </div>
    <div class="form-check form-check-inline">
        {{ Form::radio('claim_resuft', '3' , $claimWordSheet->claim_resuft == 3 ? true : false) }}
        <label class="form-check-label" for="inlineRadio3">{{config("constants.claim_result.3")}}</label>
    </div>
</div><br>
<div>
    <p class="font-weight-bold">Received claim documents (please check)</p>
    <div class="row">
        <div class="col-md-4">
            <div class="form-check form-check-inline">
                {{ Form::hidden('notification', '0')}}
                {{ Form::checkbox('notification', '1', $claimWordSheet->notification == 1? true : false , ['class' => 'form-check-input'])}}
                <label class="form-check-label" for="inlineCheckbox1">Notification of Claim form</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check form-check-inline">
                {{ Form::hidden('dischage_summary', '0')}}
                {{ Form::checkbox('dischage_summary', '1', $claimWordSheet->dischage_summary == 1? true : false , ['class' => 'form-check-input'])}}
                <label class="form-check-label" for="inlineCheckbox1">Discharge summary</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check form-check-inline">
                {{ Form::hidden('vat', '0')}}
                {{ Form::checkbox('vat', '1', $claimWordSheet->vat == 1? true : false , ['class' => 'form-check-input'])}}
                <label class="form-check-label" for="inlineCheckbox1">VAT invoice (Original/Copy)</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check form-check-inline">
                {{ Form::hidden('copy_of', '0')}}
                {{ Form::checkbox('copy_of', '1', $claimWordSheet->copy_of == 1? true : false , ['class' => 'form-check-input'])}}
                <label class="form-check-label" for="inlineCheckbox1">Copy of ID/Passport/ Coverage card</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check form-check-inline">
                {{ Form::hidden('medical_report', '0')}}
                {{ Form::checkbox('medical_report', '1', $claimWordSheet->medical_report == 1? true : false , ['class' => 'form-check-input'])}}
                <label class="form-check-label" for="inlineCheckbox1">Medical report/Medical book</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check form-check-inline">
                {{ Form::hidden('breakdown', '0')}}
                {{ Form::checkbox('breakdown', '1', $claimWordSheet->breakdown == 1? true : false , ['class' => 'form-check-input'])}}
                <label class="form-check-label" for="inlineCheckbox1">Breakdown of charges</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check form-check-inline">
                {{ Form::hidden('discharge_letter', '0')}}
                {{ Form::checkbox('discharge_letter', '1', $claimWordSheet->discharge_letter == 1? true : false , ['class' => 'form-check-input'])}}
                <label class="form-check-label" for="inlineCheckbox1">Discharge letter</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check form-check-inline">
                {{ Form::hidden('treatment_plant', '0')}}
                {{ Form::checkbox('treatment_plant', '1', $claimWordSheet->treatment_plant == 1? true : false , ['class' => 'form-check-input'])}}
                <label class="form-check-label" for="inlineCheckbox1">Treatment plan</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check form-check-inline">
                {{ Form::hidden('incident_report', '0')}}
                {{ Form::checkbox('incident_report', '1', $claimWordSheet->incident_report == 1? true : false , ['class' => 'form-check-input'])}}
                <label class="form-check-label" for="inlineCheckbox1">Incident report</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check form-check-inline">
                {{ Form::hidden('prescription', '0')}}
                {{ Form::checkbox('prescription', '1', $claimWordSheet->prescription == 1? true : false , ['class' => 'form-check-input'])}}
                <label class="form-check-label" for="inlineCheckbox1">Prescription</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check form-check-inline">
                {{ Form::hidden('lab_test', '0')}}
                {{ Form::checkbox('lab_test', '1', $claimWordSheet->lab_test == 1? true : false , ['class' => 'form-check-input'])}}
                <label class="form-check-label" for="inlineCheckbox1">Lab test result</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check form-check-inline">
                {{ Form::hidden('police_report', '0')}}
                {{ Form::checkbox('police_report', '1', $claimWordSheet->police_report == 1? true : false , ['class' => 'form-check-input'])}}
                <label class="form-check-label" for="inlineCheckbox1">Police report</label>
            </div>
        </div>
    </div>
</div><br>
<div>
    <p class="font-weight-bold">Status : {{ data_get(config("constants.statusWorksheet"), $claimWordSheet->status)}}</p>
    <p class="text-danger">Vui lòng lưu lại trước khi tải work sheet về máy hoặc lưu worksheet vào tệp đã sắp sếp  !!!!</p>
    <div class="form-check form-check-inline">
        <button type="submit" name="status" value="1" class="btn btn-info m-2">{{config("constants.statusWorksheet.1")}}</button>
        @if(Auth::user()->hasRole(['Admin', 'Medical']))
            <button type="submit" name="status" value="2" class="btn btn-info">{{config("constants.statusWorksheet.2")}}</button>
        @endif
        <a href="{{route('claimWordSheets.pdf', $claimWordSheet->id)}}" target="_blank" class="btn btn-info m-2">Download Work Sheet</a>
        
        <button type="button" onclick="sendSortedFile()" class="btn btn-info m-2">lưu worksheet vào tệp đã sắp sếp</button>
        {{-- <button type="button" onclick="upload_summary()" class="btn btn-info m-2">Send Work Sheet to summary</button> --}}
    </div>
</div><br>

<div class="modal fade bd-example-modal-lg" id="onlineQueryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Online Query</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body" id="rerulf_online_query" style="max-height: 350px; overflow: scroll;">
            {{-- <pre>
                {!!print("<pre>". print_r(json_decode(trim($member->queryOnline),true)) . "</pre>")!!}
            </pre> --}}
            <div id="jsonViewer"></div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>

