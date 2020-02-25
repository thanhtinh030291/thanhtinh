<ul class="nav nav-tabs" id="myTab" role="tablist">
    @foreach ($data as $key => $itemLevel)
        <li class="nav-item">
        <a class="nav-link {{ $key == 0 ? 'active' : "" }}" id="level_{{$itemLevel->id}}-tab" data-toggle="tab" href="#level_{{$itemLevel->id}}" role="tab" aria-controls="contact" aria-selected="false">{{$itemLevel->name}}</a>
        </li>
    @endforeach
    
</ul>
<div class="tab-content" id="myTabContent">
    @foreach ($data as $key => $itemLevel)
        <div class="tab-pane fade show {{ $key == 0 ? 'active' : "" }}" id="level_{{$itemLevel->id}}" role="tabpanel" aria-labelledby="level_{{$itemLevel->id}}-tab">
            <br>
            <p>Min Amount : {{formatPrice($itemLevel->min_amount)}}</p>
            <p>Max Amount : {{formatPrice($itemLevel->max_amount)}}</p>
            <div id="manage-workflow-note-approve" class="form-container">
                {{ Form::open(array('url' => 'admin/transactionRoleStatuses', 'method' => 'post' ,'class'=>'form-horizontal')) }}
                    {{ Form::hidden('level_id', $itemLevel->id) }}
                    <div class="widget-box widget-color-blue2">
                        <div class="widget-header widget-header-small">
                            <div>
                                <button type="button" class="btn btn-secondary mt-2 btnt addinput" data-id = "{{$itemLevel->id}}">ADD</button>
                            </div>
                        </div>
                        <div class="widget-body">
                        <div class="widget-main no-padding">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-condensed table-hover "  id="season_prigce_tbl_{{$itemLevel->id}}" >
                                    <thead>
                                        <tr>
                                            <th>Current Status</th>
                                            <th>Role</th>
                                            <th>To Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="empty_item_{{$itemLevel->id}}" style="display: none;">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr id="clone_item_{{$itemLevel->id}}" style="display: none;">
                                            <td>
                                                {{ Form::select('current_status[]',$list_status, null, [ 'class' => 'form-control', 'required']) }}
                                            </td>
                                            <td>
                                                {{ Form::select('role[]',$list_role, null, [ 'class' => 'form-control', 'required']) }}
                                            </td>
                                            <td>
                                                {{ Form::select('to_status[]',$list_status, null, [ 'class' => 'form-control', 'required']) }}
                                            </td>                           
                                            <td>
                                                <button type="button" class="delete_btn btn btn-danger" style="height : 40px">&#x2613;</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="space-10"></div>
                    <button class="btn btn-primary btn-white btn-round">Update Configuration {{$itemLevel->name}}</button>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    @endforeach
</div>