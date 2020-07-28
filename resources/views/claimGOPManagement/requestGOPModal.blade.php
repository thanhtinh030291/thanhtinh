<div id="requestGOPModal" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        
        <!-- Modal content-->
        <div class="modal-content">
            {{ Form::open(array('url' => '/admin/claim/setProvGOPPresAmt/'.$data->id , 'method' => 'POST','files' => true, "id" =>  'requestGOPForm')) }}
            <div class="modal-header">
                <h4 class="modal-title">Nhập Dữ Liệu Đầu Vào</h4>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                {{ Form::hidden('cl_no', $data->code_claim_show ) }}
                {{ Form::hidden('id_claim', $data->code_claim ,['class' => 'id_claim']) }}
                
            </div>    
                        
            <div class="modal-body ">
                <div class="row">
                    {{ Form::label('prov_gop_pres_amt', 'Tổng Số Tiền Yêu Cầu Ban Đầu', ['class' => 'labelas col-md-4 mt-1']) }}
                    {{ Form::text('prov_gop_pres_amt', data_get($hospital_request,'prov_gop_pres_amt'), ['class' => 'item-price form-control col-md-5 mt-1 prov_gop_pres_amt', 'oninput' => 'gop_pres_amt_change()',"required"]) }}

                    {{ Form::label('prov_gop_pres_amt', 'File Yêu Cầu Bảo Đảm Viện Phí (PDF)', ['class' => 'labelas col-md-4 mt-1']) }}
                    <div class="col-md-5">
                        <div class="file-loading">
                            <input id="url_form_request" type="file" name="_url_form_request" >
                        </div>
                    </div>

                    {{ Form::label('prov_gop_pres_amt', 'Đính kèm email (attach email .msg)', ['class' => 'labelas col-md-4 mt-1']) }}
                    <div class="col-md-5">
                        <div class="file-loading">
                            <input id="url_attach_email" type="file" name="_url_attach_email" >
                        </div>
                    </div>
                    
                    {{ Form::label('type_gop', 'Kết Quả Bảo Lãnh', ['class' => 'labelas col-md-4 mt-1']) }}
                    {{ Form::select('type_gop', config('constants.gop_type'),data_get($hospital_request,'type_gop'), ['class' => 'form-control col-md-5 mt-1 ', "required"]) }}

                    {{ Form::label('note', 'Ghi Chú', ['class' => 'labelas col-md-4 mt-1']) }}
                    {{ Form::textarea('note', data_get($hospital_request,'note'), ['class' => 'form-control col-md-5 mt-1 ', 'rows' => "4"]) }}

                    {{ Form::label('new_items_reject', "Chi Phí Từ Chối", array('class' => 'card-title col-md-4 mt-1')) }}
                    <button type="button" class="btn btn-secondary col-md-1 mt-2 " onclick="addInputItemReject()">{{ __('message.add')}}</button>
                    <div class="col-md-4"></div>

                    <div class="col-md-4"></div>
                    <div class="col-md-5">
                        <table id="season_price_tbl" class="table table-striped header-fixed">
                            <thead>
                                <tr>
                                    <th>{{ __('message.content')}}</th>
                                    <th>{{ __('message.amount')}}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="empty_item_reject" style="display: none;">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr id="clone_item_reject" style="display: none;">
                                    <td style="width:230px">{{ Form::text('_content_default', null, ['class' => 'form-control p-1']) }}</td>
                                    <td style="width:230px">
                                        {{ Form::text('_amount_default', null, ['class' => 'item-price form-control p-1 reject_input', 'oninput' => 'gop_pres_amt_change()']) }}
                                    </td>
                                    <td>
                                        <button type="button" class="delete_btn btn btn-danger float-right p-2" style="height : 40px">&#x2613;</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    

                    {{ Form::label('APPAMTGOP', 'Chi Phí Bảo Lãnh Dự Kiến', ['class' => 'labelas col-md-4 mt-1']) }}
                    {{ Form::text('APPAMTGOP', null, ['class' => 'app_amt_gop item-price form-control col-md-5 mt-1', 'readonly']) }}
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div id = 'button_save' class="pull-right">
                        <button class="btn btn-danger" name="save_letter" value="save"> Submit</button> 
                        <button type="button" class="btn btn-secondary btn-cancel-delete" 
                            data-dismiss="modal">Close</button>
                    </div><br>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>