<table id="season_price_tbl" class="table table-striped header-fixed">
    <thead>
        <tr>
            <th>{{ __('message.content')}}</th>
            <th>{{ __('message.amount')}}</th>
            <th>{{ __('message.reason_reject')}}</th>
            <th>{{ __('message.template')}}</th>
        </tr>
    </thead>
    <tbody>
        <tr id="empty_item" style="display: none;">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr id="clone_item" style="display: none">
            <td style="width:230px">{{ Form::text('_content_default', null, ['class' => 'form-control p-1 ', 'onkeydown'=>'search2(this)', 'onchange' => 'binding2Input(this, "nameItem_defautl")' ]) }}</td>
            <td style="width:130px">
                {{ Form::text('_amount_default', null, ['class' => 'item-price form-control p-1', 'onchange' => 'binding2Input(this, "amountItem_defautl")']) }}
            </td>
            <td style="width:280px">
                <div style="width:280px">
                    {{ Form::select('_reasonInject_default', $listReasonReject,null, ['class' => ' form-control' ,'placeholder' => 'Not Reject' , 'onchange' => 'template(this)']) }}
                </div>
            </td>
            
            <td>
                <div class="row">
                    <div class="col-md-11" id ="template_default" >None</div>
                    <button type="button" class="delete_btn btn btn-danger float-right col-md-1  p-0" style="height : 40px">&#x2613;</button>
                </div>
            </td>
        </tr>
    </tbody>
</table>