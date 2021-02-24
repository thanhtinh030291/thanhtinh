<div id="comfirmRenewalModal" class="modal fade bd-example-modal-lg" role="dialog">
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
                    {{ Form::hidden('letter_template_id', null, array('id'=>'LetterTemplateId_2', 'class' => 'form-control', 'required')) }}

                    <div class="row mb-2">
                        {{ Form::label('type',  'Thời bắt đầu gia hạn' , array('class' => 'col-md-2')) }} 
                        {{ Form::text('begin_day_renewal', null , array('id' => 'begin_day_renewal','class' => 'col-md-4 form-control datepicker', 'required' )) }}
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