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
    <p class="font-weight-bold">Effective date: {{Carbon\Carbon::parse($HBS_CL_CLAIM->Police->eff_date)->format('d/m/Y')}}</p>
    </div>
    <div class="col-md-6">
    <p class="font-weight-bold">Status: </p>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <p class="font-weight-bold">Plan: </p>
    </div>
    <div class="col-md-6">
        <p>- 30 ngày chờ</p>
        <p>- 1 năm chờ</p> 
        <p>- Hợp đồng/Điều khoản</p>
    </div>
</div>
<div>
    <p class="font-weight-bold">Occupation Loading: </p>
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
</div>

<div>
    <p class="font-weight-bold">MEDICAL OPINIONS</p>
    {!! Form::textarea('medical', $claimWordSheet->assessment,['class' => 'editor_default2' , 'rows' => "4"]) !!}
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
                <input class="form-check-input" type="checkbox" name="notification"  value="1">
                <label class="form-check-label" for="inlineCheckbox1">Notification of Claim form</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="dischage_summary"  value="1">
                <label class="form-check-label" for="inlineCheckbox1">Discharge summary</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="vat"  value="1">
                <label class="form-check-label" for="inlineCheckbox1">VAT invoice (Original/Copy)</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="copy_of"  value="1">
                <label class="form-check-label" for="inlineCheckbox1">Copy of ID/Passport/ Coverage card</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="medical_report"  value="1">
                <label class="form-check-label" for="inlineCheckbox1">Medical report/Medical book</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="breakdown"  value="1">
                <label class="form-check-label" for="inlineCheckbox1">Breakdown of charges</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="discharge_letter"  value="1">
                <label class="form-check-label" for="inlineCheckbox1">Discharge letter</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="treatment_plant"  value="1">
                <label class="form-check-label" for="inlineCheckbox1">Treatment plan</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="incident_report"  value="1">
                <label class="form-check-label" for="inlineCheckbox1">Incident report</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="prescription"  value="1">
                <label class="form-check-label" for="inlineCheckbox1">Prescription</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="lab_test"  value="1">
                <label class="form-check-label" for="inlineCheckbox1">Lab test result</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="police_report"  value="1">
                <label class="form-check-label" for="inlineCheckbox1">Police report</label>
            </div>
        </div>
    </div>
</div>
