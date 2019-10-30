function showTiff(file) {
    $('#list-page').empty();
    var reader = new FileReader();
    reader.onload = (function (theFile) {
        return function (e) {
            var buffer = e.target.result;
            var tiff = new Tiff({buffer: buffer});
            for (var i = 0, len = tiff.countDirectory(); i < len; ++i) {
                var num = parseInt(i) + 1;
                if(i == selectpage){
                    $('#list-page').append($('<button type="button" class= "btn btn-warning" onClick="clickPage(this)" data-id = "'+i+'">'+num+'</button>'));
                }else{
                    $('#list-page').append($('<button type="button" class= "btn btn-primary" onClick="clickPage(this)" data-id = "'+i+'">'+num+'</button>'));
                }
                
                if(i == selectpage){
                    tiff.setDirectory(i);
                    var canvas = tiff.toCanvas();
                    $('#show-page').empty().append(canvas);
                }
                
            }
        };
    })(file);
    reader.readAsArrayBuffer(file);
}

function clickPage(e){
    selectpage = e.dataset.id;
    showTiff(trialImage);
}
// button go click 
function clickGo(){
    var text = $("#select-inject-default option:selected").text();
    var valueSelect = $("#select-inject-default option:selected").val();
    var arrElementcheck = $('.checkbox_class');
    $.each(arrElementcheck, function (index, value) {
        var id = value.dataset.id;
        if(value.checked){
            $('#btnConfirm'+id).show();
            $('#btnConfirm'+id).attr("title",text);
            $('#inputReject'+id).prop("checked", false);
            $('#reason'+id).val(valueSelect);
        }
    });
    $('.checkbox_class, .form-check-input').attr('checked', false);


};

// lick checkbox show buton comfirm
function clickInject(e){
    var row = e.dataset.id;
    if(!e.checked) {
        $("#btnConfirm"+row).show();
    }else{
        $("#btnConfirm"+row).hide();
        $("#reason"+row).val('');
    }
}

// add value default to modal
$(document).on("click", ".btnConfirm", function(){
    var id = $(this).data('id');
    $('#id_row').val(id);
    var oldValue = $('#reason'+id).val();
    $('#select-reason').val(oldValue).change();
});

// delete row in table
$(document).on("click", ".delete_row_btn", function(){
    //$(this).closest('tr').remove();
    $(this).toggleClass("btn-danger");
    if($(this).hasClass("btn-danger")){
        $(this).closest('tr').removeClass('bg-secondary');
        $(this).closest('tr').find('input').prop('disabled', false);
    } else{
        
        $(this).closest('tr').addClass('bg-secondary');
        $(this).closest('tr').find('input').prop('disabled', true);
    }
    
    //$(this).parents('tr').find('input').prop('disabled', false);
});

// get input 
var trialImage;
var selectpage = 0;
var fileCSV;
$('#fileUpload').fileinput({
    required: false,
    allowedFileExtensions: ['csv']
}).on("filebatchselected", function(event, files) {
    fileCSV = files;
    
});

function btnScan(){
    if (typeof fileCSV === 'undefined') {
        alert('Please enter file');
    }else{
        $( "#dvExcel" ).empty();
        excelToHtml(fileCSV);
        
    } 
}

$('#fileUpload2').fileinput({
    required: false,
    allowedFileExtensions: ['tiff','tif','TIFF','TIF']
}).on("filebatchselected", function(event, files) {
    trialImage = files[0];
    showTiff(trialImage);
});

//button checkall click
function checkAll(e){
    $(".checkbox_class").prop("checked", e.checked);
}

// setting on off div preview
$( function() {
    $( "#page" ).draggable();
} );
$(document).ready(function () {
    $(".button-preview").click(function () {
        $("#page").toggle(1000);
    });
});
// button sum amount 
function totalAmount(){
    var sum = 0;
    $(".item-amount").each(function() {
        
        if(! $(this).closest('tr').hasClass('bg-secondary')){
            var value = $(this).val();
            value = value.replace(/[,]/g, "");
            // add only if the value is number
            if(!isNaN(value) && value.length != 0) {
                sum += parseFloat(value);
            }
        }
    });
    $('#totalAmount').text(formatPrice(sum));
}


function excelToHtml(file) {
    data = file[0];
    $('#fileUpload').parse({
        config: {
            delimiter: "",	// auto-detect
            newline: "",	// auto-detect
            quoteChar: '"',
            escapeChar: '"',
            header: false,
            transformHeader: undefined,
            dynamicTyping: false,
            preview: 0,
            encoding: "",
            worker: false,
            comments: false,
            step: undefined,
            complete: completeFn,
            error: undefined,
            download: false,
            downloadRequestHeaders: undefined,
            skipEmptyLines: false,
            chunk: undefined,
            fastMode: undefined,
            beforeFirstChunk: undefined,
            withCredentials: undefined,
            transform: undefined,
            delimitersToGuess: [',', '\t', '|', ';', Papa.RECORD_SEP, Papa.UNIT_SEP]
        },
        before: function(file, inputElem)
        {
            
        },
        error: function(err, file)
        { 
        },
        complete: function()
        {
        }
    });
};
function completeFn(results)
{
    $('#dvExcel').append(arrayToTable(results.data));
    $('.select2').select2();
}

// check form

function checkValueCol(value, arrElemt){
    arrElemt.removeClass("item-price");
    arrElemt.removeClass("item-content");
    switch (value) {
        case 'amount':
            {   
                arrElemt.addClass("item-amount");
                arrElemt.addClass("item-price");
                arrElemt.val().replace(/[.]/g,",");
                var arrayElement = document.getElementsByClassName('item-price');
                $.each(arrayElement, function (index, value) {
                    $(this).attr({'id' : 'table1_amount_'+value.dataset.id, 'onchange': "binding2Input(this, 'table1_amountItem_"+value.dataset.id+"')"});
                    var st = $(this).val().replace(/[.]/g, ",");
                    st = st.toLowerCase();
                    st = st.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|o/gi, '0');
                    if(st.split(",").pop() == '00'){
                        st = st.split(",");
                        st.pop();
                        st = st.join(',')
                    }
                    //st = formatPrice(st);
                    var  check = checkPriceFormat(st, $(this));
                    $(this).val(st);
                });
            }
            break;
        case 'content':
            {
                arrElemt.addClass("item-content");
                $('.result').empty();
                $.each(arrElemt, function (index, value) {
                    $(this).attr({'id': 'table1_name_'+value.dataset.id, 'onchange': "binding2Input(this, 'table1_nameItem_"+value.dataset.id+"')"});
                    if ($(this).val() == '') {
                        
                    } else {
                        $.ajax({
                            url: '/admin/search',
                            type: 'POST',
                            context: this,
                            data: {'search' : $(this).val()},
                        })
                        .done(function(res) {
                            if(res.status == 'success'){
                                $(this).after($("<div class ='mt-2 ml-1 row result'></div>")
                                    .append($("<textarea class ='form-control col-md-9'   type='text'> "+res.data.name+" </textarea>"))  
                                    .append("<p class='p-0 col-md-3'><button type='button' class='mt-3 btn btn-primary'>"+res.data.percent+" %</button></p>")       
                                );
                            }
                        })
                    };
                })
            }
            break
        default:
            break;
    }
}
// search2 ajax
function search2(e){
    var id = e.dataset.id;
    $.ajax({
        url: '/admin/search2',
        type: 'POST',
        context: e,
        data: {'search' : e.value},
    })
    .done(function(res) {
        if(res.status == 'success'){
            $("#result_suggestions").empty();
            var container = $("#result_suggestions");
            res.data.forEach(function(value, key) {
                var p = $("<input>", {
                    value: value,
                    class: "div-added",
                    id : 'result_suggestions_'+key
                });
                var div =  $('<div class="input-group mb-3"></div>');
                div.append('<input type="text" data-id="'+id+'" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1" value="'+value+'" id="result_suggestions_'+key+'">')
                    .append($('<div class="input-group-append"></div>')
                        .append('<button class="btn btn-outline-secondary" data-id="'+id+'" data-clipboard-demo data-clipboard-target="#result_suggestions_'+key+'" type="button"><i class="fa fa-clipboard" aria-hidden="true"></i></button>'));
                container.append(div);
            });
        }else{
            $("#result_suggestions").empty();
        }
    })
}

//btn delete table item 
$(document).on("click", ".delete_btn", function(){
    $(this).closest('tr').remove();
});
//add input item
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
// ajax template
function template(e , idElement , table){

    var id = e.dataset.id;
    var container = $("#"+idElement);
    $.ajax({
        url: '/admin/template',
        type: 'POST',
        context: e,
        data: {'search' : e.value},
    })
    .done(function(res) {
        if(res.status == 'success'){
                container.empty();
                container.append(replaceTemplace(res.data, id ,table));
                loadDatepicker();
        }else{
                container.empty();
        }
    })
}

// replace template 
    function replaceTemplace(str , id = null , table = ""){
        var result = str.replace(/\[##Text##\]/g,'<input type="text" name="'+table+'_parameters['+id+'][]" class="form-control text-template p-1" required />');
        result = result.replace(/\[##Date##\]/g,'<input type="text" name="'+table+'_parameters['+id+'][]" class="form-control date-template datepicker p-1" required />');
        var nameItem = $('#'+table+'_name_'+id).val() ;
        result = result.replace(/\[##nameItem##\]/g,'<input type="text" name="'+table+'_parameters['+id+'][]" class="'+table+'_nameItem_'+id+' form-control text-template p-1" value="'+nameItem+'" required readonly/>');
        var amountItem = $('#'+table+'_amount_'+id).val() ;
        result = result.replace(/\[##amountItem##\]/g,'<input type="text" name="'+table+'_parameters['+id+'][]" class="'+table+'_amountItem_'+id+' form-control text-template p-1" value="'+amountItem+'" required readonly/>');
        return result;
    }

    function binding2Input(e , classElement){
        $('.'+classElement).val(e.value);
    }
// shortenTable

function shortenTable(){
    if($('#dvExcel tr:nth-child(1) .colContent').length > 0 && $('#dvExcel tr:nth-child(1) .colAmount').length > 0){
        var arrRemove = [];
        $('#dvExcel tr:nth-child(1) th').each(function (num) {
            if ($(this).hasClass('colContent') || $(this).hasClass('colAmount') || num == 0 || num == 1 || num == 2 ) {
            }else{
                //$('#dvExcel table tr').find('td:eq('+num+'),th:eq('+num+')').remove();
                arrRemove.push('td:eq('+num+')');
                arrRemove.push('th:eq('+num+')');
            }
        });
        var strRemove = arrRemove.join();
        $('#dvExcel table tr').find(strRemove).remove();
    }else{
        alert('Please choice a column as "content" & "amount" ');
    }
    
    
}

//set get  idPaste 
var idPaste ;
function setIdPaste(e){
    idPaste = e.dataset.id;
}

function removeIdPaste(){
    idPaste = null;
};
//copy text to content
var clipboard = new ClipboardJS('.btn');
clipboard.on('success', function(e) {
    if(idPaste){
        $("#table2_name_"+idPaste).val(e.text);
        removeIdPaste();
    }
    else{
        alert('Please select the region to paste');
    }
});
// choice field 
$(document).on("change", ".select_field", function(e){
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;
    var id = $(this).attr('id');
    var col = parseInt(id) + 4;
    switch (valueSelected) {
        case 'content':
            $("th").removeClass("colContent");
            $(this).closest('th').addClass('colContent');
            break;
        case 'amount':
            $("th").removeClass("colAmount");
            $(this).closest('th').addClass('colAmount');
            break;
        default:
            $(this).closest('th').removeClass("colContent").removeClass("colAmount");
            break;
    }
    var arrElement = $("tr td:nth-child("+col+") input");
    checkValueCol(valueSelected, arrElement);
});

//ajax select code
$(document).ready(function() {
    $('.code_claim').select2({          
        minimumInputLength: 2,
        ajax: {
        url: "/admin/dataAjaxHBSClaim",
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
            url: "/admin/loadInfoAjaxHBSClaim",
            type: 'POST',
            
            data: {'search' : value},
        })
        .done(function(res) {
            
            container.empty();
            container.append('<p class="card-text">Full-Name: '+res.mbr_last_name +' '+res.mbr_first_name+'</p>')
            .append('<p class="card-text">Member No: '+ res.mbr_no +'</p>')
            .append('<p class="card-text">Member Ref No: '+ res.memb_ref_no +'</p>')
        })
    }
});
