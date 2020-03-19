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
    <p class="font-weight-bold">Policy No: {{$HBS_CL_CLAIM->Police->pocy_no}}</p>
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
    <p class="font-weight-bold">Status:  {!!$member->statusQuery!!}</p>
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
        <p>- 30 ngày chờ</p>
        <p>- 1 năm chờ</p> 
        <p>- Hợp đồng/Điều khoản</p>
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
</div>

<div class="row">
    <div class="col-sm-2 col-form-label ">
        <p class="font-weight-bold">Type of visit: IP / OP </p>
    </div>
</div>

<table id="season_price_tbl" class="table table-striped header-fixed w-50">
    <tbody>
        @if(!empty($HBS_CL_CLAIM->HBS_CL_LINE))
        @foreach ($HBS_CL_CLAIM->HBS_CL_LINE as $item)
            <tr>
                <td>
                    <p><span class="font-weight-bold">Incur date: </span> From {{Carbon\Carbon::parse($item->incur_date_from)->format('d/m/Y')}} To  {{Carbon\Carbon::parse($item->incur_date_to)->format('d/m/Y')}} 
                        <span class="font-weight-bold">Diagnosis: </span>  {{$item->prov_name}} </p>
                </td>
            </tr>
        @endforeach
        @endif
    </tbody>
</table>

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
                    <td>{{$item->prov_name}}</td>
                    <td>{{str_replace("BENEFIT_TYPE_", "", $item->PD_BEN_HEAD->scma_oid_ben_type)}}</td>
                    <td>{{formatPrice($item->app_amt)}}</td>
                </tr>
            @endforeach
            @endif
                
        </tbody>
    </table>
</div>

<div>
    <p class="font-weight-bold">MEMBER CLAIM EVENT</p>
    <table class="table table-striped header-fixed w-50">
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
    {!! Form::textarea('assessment', $claimWordSheet->assessment,['class' => 'editor_default2' , 'rows' => "4"]) !!}
</div><br>

<div>
    <p class="font-weight-bold">MEDICAL OPINIONS  <button class="add_field_button">Add Question</button></p>
    <div class="input_fields_wrap w-75 ml-4">
        @foreach ($claimWordSheet->request_qa as $item)
        <div class = "row mt-2">
            
            {{ Form::text('request_qa[]', $item , ['class'=>"form-control col-md-11"]) }}
            <a href="#" class="col-md-1 remove_field btn btn-danger">X</a>
        </div>
        @endforeach
        
        
    </div><br>
    {!! Form::textarea('medical', $claimWordSheet->medical,[
        'class' => Auth::user()->hasRole('Medical') ?  'editor_default2' : 'editor_readonly' , 
        'rows' => "4" , 'disabled']) !!}
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
    
    <div class="form-check form-check-inline">
        <button type="submit" name="status" value="1" class="btn btn-info m-2">{{config("constants.statusWorksheet.1")}}</button>
        @if(Auth::user()->hasRole(['Admin', 'Medical']))
            <button type="submit" name="status" value="2" class="btn btn-info">{{config("constants.statusWorksheet.2")}}</button>
        @endif
        <a href="{{route('claimWordSheets.pdf', $claimWordSheet->id)}}" target="_blank" class="btn btn-info m-2">Download PDF</a>
    </div>
</div><br>

