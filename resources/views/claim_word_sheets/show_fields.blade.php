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
    <p class="font-weight-bold">Loading: </p>
    <p class="font-weight-bold">Exclusion: </p>
</div>

<div class="row">
    <div class="col-sm-2 col-form-label ">
        <p class="font-weight-bold">Type of visit: IP / OP </p>
    </div>
    <div class="col-sm-9">
        <button type="button" class="btn btn-secondary mt-2 btnt" onclick="addInputItem()">{{ __('message.add')}}</button>
    </div>
</div>

<table id="season_price_tbl" class="table table-striped header-fixed">
    
    <tbody>
        <tr id="empty_item" style="display: none;">
            <td></td>
        </tr>
        <tr id="clone_item" style="display: none">
            <td>
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <label for="staticEmail2" class="font-weight-bold">Incur date:  From</label>
                    </div>
                    
                    <div class="col-auto">
                            <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="dd/mm/yyyy" class=" imask-input">
                    </div>
                    <div class="col-auto">
                        <label for="staticEmail2" class="font-weight-bold">To</label>
                    </div>
                    <div class=" col-auto">
                        <input type="text" class="form-control" id="inlineFormInputGroup2" placeholder="dd/mm/yyyy" class=" imask-input">
                    </div>
                    <div class="col-auto">
                        <label for="staticEmail2" class="font-weight-bold">Diagnosis</label>
                    </div>
                    <div class=" col-auto">
                            <input type="text" class="form-control" id="inlineFormInputGroup3"  >
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary delete_btn">X</button>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<div>
    <p class="font-weight-bold">CLAIM HISTORY</p>
    <table class="table table-striped header-fixed">
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
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
            @endif
                
        </tbody>
    </table>
</div>

<div>
    <p class="font-weight-bold">MEMBER CLAIM EVENT</p>
    <table class="table table-striped header-fixed">
        <thead>
            <th>Date</th>
            <th>Description</th>
        </thead>
        <tbody>
            
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
</div>

<div>
    <p class="font-weight-bold">Claim result</p>
    {!! Form::textarea('medical', $claimWordSheet->assessment,$claimWordSheet->claim_resuft,['class' => 'editor_default2' , 'rows' => "4"]) !!}
</div>





<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $claimWordSheet->id !!}</p>
</div>

<!-- Claim Id Field -->
<div class="form-group">
    {!! Form::label('claim_id', 'Claim Id:') !!}
    <p>{!! $claimWordSheet->claim_id !!}</p>
</div>

<!-- Mem Ref No Field -->
<div class="form-group">
    {!! Form::label('mem_ref_no', 'Mem Ref No:') !!}
    <p>{!! $claimWordSheet->mem_ref_no !!}</p>
</div>

<!-- Visit Field -->
<div class="form-group">
    {!! Form::label('visit', 'Visit:') !!}
    <p>{!! $claimWordSheet->visit !!}</p>
</div>

<!-- Assessment Field -->
<div class="form-group">
    {!! Form::label('assessment', 'Assessment:') !!}
    <p>{!! $claimWordSheet->assessment !!}</p>
</div>

<!-- Medical Field -->
<div class="form-group">
    {!! Form::label('medical', 'Medical:') !!}
    <p>{!! $claimWordSheet->medical !!}</p>
</div>

<!-- Claim Resuft Field -->
<div class="form-group">
    {!! Form::label('claim_resuft', 'Claim Resuft:') !!}
    <p>{!! $claimWordSheet->claim_resuft !!}</p>
</div>

<!-- Note Field -->
<div class="form-group">
    {!! Form::label('note', 'Note:') !!}
    <p>{!! $claimWordSheet->note !!}</p>
</div>

<!-- Notification Field -->
<div class="form-group">
    {!! Form::label('notification', 'Notification:') !!}
    <p>{!! $claimWordSheet->notification !!}</p>
</div>

<!-- Dischage Summary Field -->
<div class="form-group">
    {!! Form::label('dischage_summary', 'Dischage Summary:') !!}
    <p>{!! $claimWordSheet->dischage_summary !!}</p>
</div>

<!-- Vat Field -->
<div class="form-group">
    {!! Form::label('vat', 'Vat:') !!}
    <p>{!! $claimWordSheet->vat !!}</p>
</div>

<!-- Copy Of Field -->
<div class="form-group">
    {!! Form::label('copy_of', 'Copy Of:') !!}
    <p>{!! $claimWordSheet->copy_of !!}</p>
</div>

<!-- Medical Report Field -->
<div class="form-group">
    {!! Form::label('medical_report', 'Medical Report:') !!}
    <p>{!! $claimWordSheet->medical_report !!}</p>
</div>

<!-- Breakdown Field -->
<div class="form-group">
    {!! Form::label('breakdown', 'Breakdown:') !!}
    <p>{!! $claimWordSheet->breakdown !!}</p>
</div>

<!-- Discharge Letter Field -->
<div class="form-group">
    {!! Form::label('discharge_letter', 'Discharge Letter:') !!}
    <p>{!! $claimWordSheet->discharge_letter !!}</p>
</div>

<!-- Treatment Plant Field -->
<div class="form-group">
    {!! Form::label('treatment_plant', 'Treatment Plant:') !!}
    <p>{!! $claimWordSheet->treatment_plant !!}</p>
</div>

<!-- Incident Report Field -->
<div class="form-group">
    {!! Form::label('incident_report', 'Incident Report:') !!}
    <p>{!! $claimWordSheet->incident_report !!}</p>
</div>

<!-- Prescription Field -->
<div class="form-group">
    {!! Form::label('prescription', 'Prescription:') !!}
    <p>{!! $claimWordSheet->prescription !!}</p>
</div>

<!-- Lab Test Field -->
<div class="form-group">
    {!! Form::label('lab_test', 'Lab Test:') !!}
    <p>{!! $claimWordSheet->lab_test !!}</p>
</div>

<!-- Police Report Field -->
<div class="form-group">
    {!! Form::label('police_report', 'Police Report:') !!}
    <p>{!! $claimWordSheet->police_report !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $claimWordSheet->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $claimWordSheet->updated_at !!}</p>
</div>

<!-- Created User Field -->
<div class="form-group">
    {!! Form::label('created_user', 'Created User:') !!}
    <p>{!! $claimWordSheet->created_user !!}</p>
</div>

<!-- Updated User Field -->
<div class="form-group">
    {!! Form::label('updated_user', 'Updated User:') !!}
    <p>{!! $claimWordSheet->updated_user !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $claimWordSheet->deleted_at !!}</p>
</div>

