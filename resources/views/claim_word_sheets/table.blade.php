<div class="table-responsive">
    <table class="table" id="claimWordSheets-table">
        <thead>
            <tr>
                <th>Claim Id</th>
        <th>Mem Ref No</th>
        <th>Visit</th>
        <th>Assessment</th>
        <th>Medical</th>
        <th>Claim Resuft</th>
        <th>Note</th>
        <th>Notification</th>
        <th>Dischage Summary</th>
        <th>Vat</th>
        <th>Copy Of</th>
        <th>Medical Report</th>
        <th>Breakdown</th>
        <th>Discharge Letter</th>
        <th>Treatment Plant</th>
        <th>Incident Report</th>
        <th>Prescription</th>
        <th>Lab Test</th>
        <th>Police Report</th>
        <th>Created User</th>
        <th>Updated User</th>
        <th>Deleted At</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($claimWordSheets as $claimWordSheet)
            <tr>
                <td>{!! $claimWordSheet->claim_id !!}</td>
            <td>{!! $claimWordSheet->mem_ref_no !!}</td>
            <td>{!! $claimWordSheet->visit !!}</td>
            <td>{!! $claimWordSheet->assessment !!}</td>
            <td>{!! $claimWordSheet->medical !!}</td>
            <td>{!! $claimWordSheet->claim_resuft !!}</td>
            <td>{!! $claimWordSheet->note !!}</td>
            <td>{!! $claimWordSheet->notification !!}</td>
            <td>{!! $claimWordSheet->dischage_summary !!}</td>
            <td>{!! $claimWordSheet->vat !!}</td>
            <td>{!! $claimWordSheet->copy_of !!}</td>
            <td>{!! $claimWordSheet->medical_report !!}</td>
            <td>{!! $claimWordSheet->breakdown !!}</td>
            <td>{!! $claimWordSheet->discharge_letter !!}</td>
            <td>{!! $claimWordSheet->treatment_plant !!}</td>
            <td>{!! $claimWordSheet->incident_report !!}</td>
            <td>{!! $claimWordSheet->prescription !!}</td>
            <td>{!! $claimWordSheet->lab_test !!}</td>
            <td>{!! $claimWordSheet->police_report !!}</td>
            <td>{!! $claimWordSheet->created_user !!}</td>
            <td>{!! $claimWordSheet->updated_user !!}</td>
            <td>{!! $claimWordSheet->deleted_at !!}</td>
                <td>
                    {!! Form::open(['route' => ['claimWordSheets.destroy', $claimWordSheet->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('claimWordSheets.show', [$claimWordSheet->id]) !!}" class='btn btn-success btn-xs'><i class="fa fa-eye"></i></a>
                        <a href="{!! route('claimWordSheets.edit', [$claimWordSheet->id]) !!}" class='btn btn-primary btn-xs'><i class="fa fa-pencil-square-o"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
