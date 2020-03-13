@extends('layouts.admin.master')
@section('title', 'Claim Word Sheet')
@section('stylesheets')
    <link href="{{ asset('css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-ui.min.css') }}">
    <link href="{{ asset('css/setting_date.css') }}" media="all" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include('layouts.admin.breadcrumb_index', [
        'title'       => 'Claim Work Sheet',
        'parent_url'  =>  route('claimWordSheets.index'),
        'parent_name' => 'Claim Work Sheets',
        'page_name'   => 'Claim Work Sheet',
    ])
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @include('claim_word_sheets.show_fields')
                    <a href="{!! route('claimWordSheets.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="{{asset('js/imask.js')}}"></script>
<script src="{{ asset('js/tinymce.js?vision=') .$vision }}"></script>
<script>
//btn delete table item 
$(document).on("click", ".delete_btn", function(){
    $(this).closest('tr').remove();
});

$('.imask-input').mask('AB/SC/MNJK', {'translation': {
    A: {pattern: /[0-3]/},
    B: {pattern: /[0-9]/},
    S: {pattern: /[0-1]/},
    C: {pattern: /[0-9]/},
    M: {pattern: /[0-2]/},
    N: {pattern: /[0-9]/},
    J: {pattern: /[0-9]/},
    K: {pattern: /[0-9]/},
}
});
var count = 1;
function addInputItem(){
    let clone =  '<tr id="row-'+count+'">';
    clone += '<input name = "_idItem['+count+']" type="hidden" >';
    clone +=  $("#clone_item").clone().html() + '</tr>';
    //repalace name
    clone = clone.replace("_content_default", "_content["+count+"]");
    clone = clone.replace("_amount_default", "_amount["+count+"]");
    clone = clone.replace("_reasonInject_default", "_reasonInject["+count+"]");
    // div template id
    clone = clone.replace('template_default', "template_"+count);
    // parameter in function
    clone = clone.replace('nameItem_defautl', "table2_nameItem_"+count);
    clone = clone.replace('amountItem_defautl', "table2_amountItem_"+count);
    clone = clone.replace('template_idElement', "template_"+count);
    // id
    clone = clone.replace('table2_name_default', "table2_name_"+count);
    clone = clone.replace('table2_amount_default', "table2_amount_"+count);
    
    
    $("#empty_item").before(clone);
    $('input[name="_content['+count+']"]').attr({"required": "true", 'data-id': count, 'id': 'table2_name_'+count, 'onclick':"setIdPaste(this)"});
    $('input[name="_amount['+count+']"]').attr({"required": "true", 'id': 'table2_amount_'+count});
    $('select[name="_reasonInject['+count+']"]').addClass('select2').attr('data-id', count);
    $('.select2').select2();
    count++;
}
function addValueItem(content, amount, reasonInject, count, idItem = ""){
    $('input[name="_content['+count+']"]').val(content);
    $('input[name="_amount['+count+']"]').val(amount);
    $('select[name="_reasonInject['+count+']"]').val(reasonInject).change();
    $('input[name="_idItem['+count+']"]').val(idItem);
}
</script>
@endsection
