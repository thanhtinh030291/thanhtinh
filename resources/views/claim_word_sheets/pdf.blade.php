<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <head>
        
        <style>
        @font-face {
            font-family: "DejaVu Sans";
            font-style: normal;
            font-weight: 400;
            src: url("/fonts/dejavu-sans/DejaVuSans.ttf");
            /* IE9 Compat Modes */
            src: 
                local("DejaVu Sans"), 
                local("DejaVu Sans"), 
                url("/fonts/dejavu-sans/DejaVuSans.ttf") format("truetype");
            }
            h1, .h1 {
            font-size: 2.5rem;
            }

            h2, .h2 {
            font-size: 2rem;
            }

            h3, .h3 {
            font-size: 1.75rem;
            }

            h4, .h4 {
            font-size: 1.5rem;
            }

            h5, .h5 {
            font-size: 1.25rem;
            }

            h6, .h6 {
            font-size: 1rem;
            }

            
            body { 
            font-family: "DejaVu Sans";
            font-size:
            }
            .font-weight-bold {
                font-size: 16px;
            }
            table { 
                width: 750px; 
                border-collapse: collapse; 
                margin:7px auto;
                }

            /* Zebra striping */
            tr:nth-of-type(odd) { 
                background: #eee; 
                }

            th { 
                background: #5a5858; 
                color: white; 
                font-weight: bold; 
                }

            td, th { 
                padding: 5px; 
                border: 1px solid #ccc; 
                text-align: left; 
                font-size: 14px;
                }
            p {
                margin-top: 0;
                margin-bottom: 0.5rem;
                font-size: 14px;
                }
        </style>
    </head>
</head>
<body>
    <h2 style="text-align: center;">Claim Work Sheet</h2>
<div style="position: absolute; right: 5px; top: 0px;">
    <table class="table table-striped" style="width: 140px">
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

<table class="table" style="margin-top: 20px;">
    <tr>
        <td>
            <p class="font-weight-bold">Name: {{$member->mbr_last_name ." " . $member->mbr_first_name}}</p>
        </td>
        <td align="center">
            <p class="font-weight-bold" >DOB: {{ Carbon\Carbon::parse($member->dob)->format('d/m/Y') }}</p>
        </td>
        <td>
            <p class="font-weight-bold">Sex: {{str_replace("SEX_", "",$member->scma_oid_sex)}}</p>
        </td>
    </tr>

    <tr>
        <td>
            <p class="font-weight-bold">Policy No: {{$HBS_CL_CLAIM->Police->pocy_ref_no}}</p>
        </td>
        <td>
            <p class="font-weight-bold">Member No: {{ $member->memb_ref_no}}</p>
        </td>
        <td>
            <p class="font-weight-bold">Claim No.: {{$claim->code_claim_show}}</p>
        </td>
    </tr>

    <tr>
        <td>
            <p class="font-weight-bold">Effective date: {{$member->pocyEffdate}}</p>
        </td>
        <td></td>
        <td>
            <p class="font-weight-bold">Status:  {!!$claimWordSheet->status_online_query ? $claimWordSheet->status_online_query : $member->statusQuery!!}</p>
        </td>
    </tr>

    <tr>
        <td>
            <p class="font-weight-bold">Plan: </p>
            <div style="margin-left: 25px;">
                @foreach ($member->plan as $item)
                    <p>{{$item}}</p>
                @endforeach
            </div>
        </td>
        <td></td>
        <td >
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
        </tr>
    </tr>
</table>
<div style="margin-left: 10px;">
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

<div style="margin-left: 10px;">
    <p class="font-weight-bold">Type of visit: IP / OP </p>
</div>

<table id="season_price_tbl" style="margin-left: 25px;" >
    <tbody>
        @if(!empty($claimWordSheet->type_of_visit))
        @foreach ($claimWordSheet->type_of_visit as $item)
            <tr>
                <td>
                    <p><span class="font-weight-bold">Incur date: </span> From {{data_get($item,'from')}} To  {{data_get($item,'to')}} 
                        <span class="font-weight-bold">Diagnosis: </span>  {{data_get($item,'diagnosis')}}
                        @if(data_get($item,'prov_name'))
                        <span class="font-weight-bold">Prov name: </span>  {{data_get($item,'prov_name')}}
                        @endif
                    </p>
                </td>
            </tr>
        @endforeach
        @endif
    </tbody>
</table>

<div style="margin-left: 10px;">
    <p class="font-weight-bold">CLAIM HISTORY</p>
    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Diagnosis</th>
                <th>Treatment</th>
                <th>Claim result(Approved)</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($claim_line))
            @foreach ($claim_line as $item)
                <tr>
                    <td><p>{{Carbon\Carbon::parse($item->incur_date_from)->format('d/m/Y') .' - '.Carbon\Carbon::parse($item->incur_date_to)->format('d/m/Y')}}</p></td>
                    <td><p>{{$item->RT_DIAGNOSIS->diag_desc_vn}}</p></td>
                    <td><p>{{str_replace("BENEFIT_TYPE_", "", $item->PD_BEN_HEAD->scma_oid_ben_type)}} - {{$item->PD_BEN_HEAD->ben_head}}</p></td>
                    <td><p>{{formatPrice($item->app_amt)}}</p></td>
                </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>

<div style="margin-left: 10px;">
    <p class="font-weight-bold">MEMBER CLAIM EVENT</p>
    @if(!empty($member->CL_MBR_EVENT))
        <table>
            <thead>
                <tr>
                    <th align="center">Date</th>
                    <th align="center">Description</th>
                </tr>
            </thead>
            <tbody>
                
                    @foreach ($member->CL_MBR_EVENT as $item)
                        <tr>
                            <td>{{Carbon\Carbon::parse($item->eff_date)->format('d/m/Y')}}</td>
                            <td>{{$item->event_desc}}</td>
                        </tr>
                    @endforeach
                
            </tbody>
        </table>
    @endif
</div>

<div style="margin-left: 10px;">
    <p class="font-weight-bold">CLAIM ASSESSMENT</p>
    <table>
        <thead>
            <tr>
                <th align="center">Benefit</th>
                <th align="center">Reject</th>
            </tr>
        </thead>
        <tbody>
            
            <tr>
                <td>
                    @foreach ($claimWordSheet->benefit as $item)
                    <p>{{data_get($item, 'content')}} : {{formatPrice(data_get($item, 'amount'))}}</p>
                    @endforeach
                </td>
                <td>
                    @if($claim->item_of_claim)
                        @foreach ($claim->item_of_claim as $item)
                            <p>{{$item->content}} : {{formatPrice($item->amount)}}</p>
                        @endforeach
                    @endif
                </td>
            </tr>
            <tr align="center">
                <th align="center">Claim AMT : {{formatPrice($claimWordSheet->claim_amt)}}</th>
                <th align="center">PAYABLE AMT : {{formatPrice($claimWordSheet->payable_amt)}}</th>
            </tr>    
        </tbody>
    </table>
    {!! $claimWordSheet->assessment !!}
</div>

<div style="margin-left: 10px;">
    <p class="font-weight-bold">MEDICAL OPINIONS</p>
    <div style="margin-left: 25px;">
        <p>QUESTIONS</p>
        @foreach ($claimWordSheet->request_qa as $item)
        <div style="margin-left: 25px;">
            {!!$item!!}
        </div>
        @endforeach
    </div>
    <div style="margin-left: 25px;">
        <p>ANSWER</p>
        {!!  $claimWordSheet->medical !!}
    </div>
</div>

<div style="margin-left: 10px;">
    <p class="font-weight-bold">CLAIM RESULT</p>
    <table class="table">
        <tr>
            <td class="form-check form-check-inline">
                {{ Form::radio('claim_resuft', '1' , $claimWordSheet->claim_resuft == 1 ? true : false) }}
                <label class="form-check-label" for="inlineRadio1">{{config("constants.claim_result.1")}}</label>
            </td>
            <td class="form-check form-check-inline">
                {{ Form::radio('claim_resuft', '2' , $claimWordSheet->claim_resuft == 2 ? true : false) }}
                <label class="form-check-label" for="inlineRadio2">{{config("constants.claim_result.2")}}</label>
            </td>
            <td class="form-check form-check-inline">
                {{ Form::radio('claim_resuft', '3' , $claimWordSheet->claim_resuft == 3 ? true : false) }}
                <label class="form-check-label" for="inlineRadio3">{{config("constants.claim_result.3")}}</label>
            </td>
        </tr>
    </table>
</div><br>
<div style="margin-left: 10px;">
    <p class="font-weight-bold">Received claim documents (please check)</p>
    <table class="table">
        <tr>
            <td>
                <div class="form-check form-check-inline">
                    {{ Form::hidden('notification', '0')}}
                    {{ Form::checkbox('notification', '1', $claimWordSheet->notification == 1? true : false , ['class' => 'form-check-input'])}}
                    <label class="form-check-label" for="inlineCheckbox1">Notification of Claim form</label>
                </div>
            </td>
            <td>
                <div class="form-check form-check-inline">
                    {{ Form::hidden('dischage_summary', '0')}}
                    {{ Form::checkbox('dischage_summary', '1', $claimWordSheet->dischage_summary == 1? true : false , ['class' => 'form-check-input'])}}
                    <label class="form-check-label" for="inlineCheckbox1">Discharge summary</label>
                </div>
            </td>
            <td>
                <div class="form-check form-check-inline">
                    {{ Form::hidden('vat', '0')}}
                    {{ Form::checkbox('vat', '1', $claimWordSheet->vat == 1? true : false , ['class' => 'form-check-input'])}}
                    <label class="form-check-label" for="inlineCheckbox1">VAT invoice (Original/Copy)</label>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-check form-check-inline">
                    {{ Form::hidden('copy_of', '0')}}
                    {{ Form::checkbox('copy_of', '1', $claimWordSheet->copy_of == 1? true : false , ['class' => 'form-check-input'])}}
                    <label class="form-check-label" for="inlineCheckbox1">Copy of ID/Passport/ Coverage card</label>
                </div>
            </td>
            <td>
                <div class="form-check form-check-inline">
                    {{ Form::hidden('medical_report', '0')}}
                    {{ Form::checkbox('medical_report', '1', $claimWordSheet->medical_report == 1? true : false , ['class' => 'form-check-input'])}}
                    <label class="form-check-label" for="inlineCheckbox1">Medical report/Medical book</label>
                </div>
            </td>
            <td>
                <div class="form-check form-check-inline">
                    {{ Form::hidden('breakdown', '0')}}
                    {{ Form::checkbox('breakdown', '1', $claimWordSheet->breakdown == 1? true : false , ['class' => 'form-check-input'])}}
                    <label class="form-check-label" for="inlineCheckbox1">Breakdown of charges</label>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-check form-check-inline">
                    {{ Form::hidden('discharge_letter', '0')}}
                    {{ Form::checkbox('discharge_letter', '1', $claimWordSheet->discharge_letter == 1? true : false , ['class' => 'form-check-input'])}}
                    <label class="form-check-label" for="inlineCheckbox1">Discharge letter</label>
                </div>
            </td>
            <td >
                <div class="form-check form-check-inline">
                    {{ Form::hidden('treatment_plant', '0')}}
                    {{ Form::checkbox('treatment_plant', '1', $claimWordSheet->treatment_plant == 1? true : false , ['class' => 'form-check-input'])}}
                    <label class="form-check-label" for="inlineCheckbox1">Treatment plan</label>
                </div>
            </div>
            <td>
                <div class="form-check form-check-inline">
                    {{ Form::hidden('incident_report', '0')}}
                    {{ Form::checkbox('incident_report', '1', $claimWordSheet->incident_report == 1? true : false , ['class' => 'form-check-input'])}}
                    <label class="form-check-label" for="inlineCheckbox1">Incident report</label>
                </div>
            </td>
        </tr>
        <tr>
            <td >
                <div class="form-check form-check-inline">
                    {{ Form::hidden('prescription', '0')}}
                    {{ Form::checkbox('prescription', '1', $claimWordSheet->prescription == 1? true : false , ['class' => 'form-check-input'])}}
                    <label class="form-check-label" for="inlineCheckbox1">Prescription</label>
                </div>
            </td>
            <td>
                <div class="form-check form-check-inline">
                    {{ Form::hidden('lab_test', '0')}}
                    {{ Form::checkbox('lab_test', '1', $claimWordSheet->lab_test == 1? true : false , ['class' => 'form-check-input'])}}
                    <label class="form-check-label" for="inlineCheckbox1">Lab test result</label>
                </div>
            </td>
            <td>
                <div class="form-check form-check-inline">
                    {{ Form::hidden('police_report', '0')}}
                    {{ Form::checkbox('police_report', '1', $claimWordSheet->police_report == 1? true : false , ['class' => 'form-check-input'])}}
                    <label class="form-check-label" for="inlineCheckbox1">Police report</label>
                </div>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
