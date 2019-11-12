@extends('layouts.admin.master')
@section('title', 'Room And Board')
@section('stylesheets')
<link rel="stylesheet" type="text/css" href="{{asset('css/jquery-ui.min.css')}}">
@endsection
@section('content')
    @include('layouts.admin.breadcrumb_index', [
        'title'       => 'Room And Board',
        'parent_url'  => route('roomAndBoards.index'),
        'parent_name' => 'Room And Boards',
        'page_name'   =>  'Room And Board',
    ])
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => 'roomAndBoards.store']) !!}
                        <div class="form-group col-md-12">
                            {!! Form::label('name', 'Name:') !!}
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        </div>
                        
                        <!-- Code Claim Field -->
                        <div class="form-group col-md-12">
                            {!! Form::label('code_claim', 'Code Claim:') !!}
                            {{ Form::select('code_claim', [], old('code_claim'), array('id'=>'code_claim', 'class' => 'code_claim form-control', 'required')) }}
                        </div>
                        
                        
                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                            <a href="{!! route('roomAndBoards.index') !!}" class="btn btn-default">Cancel</a>
                        </div>                        
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header">Applicant Information</h5>
                <div class="card-body" id="result_applicant">
                    
                </div>
            </div>
        </div>
    </div>
    {{-- // cl line --}}
    <div class="row mt-3">
        <div class="card table-responsive col-md-12"  style="max-height:450px">
            <table id="season_price_tbl" class="table table-striped header-fixed">
                <thead>
                    <tr>
                        <th>Claim Line No.</th>
                        <th>Prov name</th>
                        <th>Pres amt</th>
                        <th>Incur date</th>
                        <th>Info</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="empty_item" style="display: none;">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr id="clone_item" style="display: none;">
                        <td style="width:100px">{{ Form::text('line_no_default', null, ['class' => 'form-control p-1 '  ]) }}</td>
                        <td style="width:330px">
                            {{ Form::text('prov_name_default', null, ['class' => 'item-price form-control p-1']) }}
                        </td>
                        <td style="width:150px">
                            {{ Form::text('pres_amt_default', null, ['class' => 'item-price form-control p-1']) }}
                        </td>
                        <td style="width:310px">
                            <div style="width:310px">
                                {{ Form::text('incur_date_default', null ,  ['class' => 'datetimepicker form-control' ,'placeholder' => 'Not Reject' ]) }}
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-success" id="btn_check_default" type="button" onclick="checkRoomBoard(this);">Check</button>
                            <div class="row">
                                <div class="col-md-11" id ="template_default" >None</div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        //ajax select code
        $(window).load(function() {
            $('.code_claim').select2({          
                minimumInputLength: 2,
                ajax: {
                url: "/admin/dataAjaxHBSClaimRB",
                    dataType: 'json',
                    data: function (params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });
            //load info of claim
            $(document).on("change","#code_claim",function(){
                resultApplicant(this.value);
            });
            $( document ).ready(function() {
                var id_code = $('#code_claim').val();
                if(id_code != null){
                    resultApplicant(id_code);
                }
            });

            function resultApplicant(value){
                var container = $("#result_applicant");
                $.ajax({
                    url: "/admin/loadInfoAjaxHBSClaimRB",
                    type: 'POST',
                    
                    data: {'search' : value},
                })
                .done(function(res) {
                    container.empty();
                    $('.claim_line').remove();
                    
                    container.append('<p class="card-text">Full-Name: '+res.HBS_CL_CLAIM.mbr_last_name +' '+res.HBS_CL_CLAIM.mbr_first_name+'</p>')
                    .append('<p class="card-text">Member No: '+ res.HBS_CL_CLAIM.mbr_no +'</p>')
                    .append('<p class="card-text">Member Ref No: '+ res.HBS_CL_CLAIM.memb_ref_no +'</p>');
                    $.each( res.HBS_CL_LINE, function(i, obj) {
                        // obj.incur_date 
                        addInputItem(obj.line_no , obj.prov_name , obj.pres_amt, obj.incur_date, obj.popl_oid);
                    });
                    loadDateTimePicker();
                })
            }            
        });

    </script>
    <script>
        var count = 1;
        function addInputItem(line_no = null , prov_name = null , pres_amt = null , incur_date = null , popl_oid = null){
            let clone =  '<tr class = "claim_line" id="row-'+count+'">';
            clone += '<input name = "_idItem['+count+']" type="hidden" >';
            clone +=  $("#clone_item").clone().html() + '</tr>';
            //repalace name
            clone = clone.replace("line_no_default", "_line_no["+count+"]");
            clone = clone.replace("prov_name_default", "_prov_name["+count+"]");
            clone = clone.replace("pres_amt_default", "_pres_amt["+count+"]");
            clone = clone.replace("incur_date_default", "_incur_date["+count+"]");

            //replace id
            clone = clone.replace("btn_check_default", "btn_check_"+count);
            clone = clone.replace("template_default", "template_"+count);

            $("#empty_item").before(clone);
            //
            $('input[name="_line_no['+count+']"]').val(line_no);
            $('input[name="_prov_name['+count+']"]').val(prov_name);
            $('input[name="_pres_amt['+count+']"]').val(pres_amt);
            $('input[name="_incur_date['+count+']"]').val(incur_date);
            $("#btn_check_"+count).attr('data-popl_oid', popl_oid);
            count++;
        }
    </script>
    <script type="text/javascript">
        function checkRoomBoard(e){
            var popl_oid = e.dataset.popl_oid;
            console.log(popl_oid);
            $.ajax({
                    url: "/admin/checkRoomBoard",
                    type: 'POST',
                    data: {'search' : popl_oid},
                })
                .done(function(res) {
                   
                })
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
@endsection