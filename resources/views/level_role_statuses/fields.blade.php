<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Min Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('min_amount', 'Min Amount:') !!}
    {!! Form::text('min_amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Max Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('max_amount', 'Max Amount:') !!}
    {!! Form::text('max_amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Begin Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('begin_status', 'Begin Status:') !!}
    {!! Form::select('begin_status', $list_status,null, ['class' => 'select2 form-control']) !!}
</div>

<!-- End Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_status', 'End Status:') !!}
    {!! Form::select('end_status', $list_status,null, ['class' => 'select2 form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('levelRoleStatuses.index') !!}" class="btn btn-default">Cancel</a>
</div>
