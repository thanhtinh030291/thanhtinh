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
}

// check form

function checkValueCol(value, arrElemt){
    arrElemt.removeClass("item-price");
    arrElemt.removeClass("item-content");
    switch (value) {
        case 'amount':
            {   
                if (value == 'amount'){
                    arrElemt.addClass("item-amount");
                } 
                arrElemt.addClass("item-price");
                arrElemt.val().replace(/[.]/g,",");
                var arrayElement = document.getElementsByClassName('item-price');
                $.each(arrayElement, function (index, value) {
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
    var clone =  '<tr id="row-'+count+'">';
    clone += '<input name = "_idItem['+count+']" type="hidden" >';
    clone +=  $("#clone_item").clone().html() + '</tr>';
    clone = clone.replace("_content_default", "_content["+count+"]");
    clone = clone.replace("_amount_default", "_amount["+count+"]");
    clone = clone.replace("_reasonInject_default", "_reasonInject["+count+"]");
    $("#empty_item").before(clone);
    $('input[name="_content['+count+']"]').attr({"required": "true", 'data-id': count, 'id': '_content'+count, 'onclick':"setIdPaste(this)"});
    $('input[name="_amount['+count+']"]').attr("required", "true");
    $('select[name="_reasonInject['+count+']"]').addClass('select2');
    $('.select2').select2();
    count++;
}
function addValueItem(content, amount, reasonInject, count, idItem = ""){
    $('input[name="_content['+count+']"]').val(content);
    $('input[name="_amount['+count+']"]').val(amount);
    $('select[name="_reasonInject['+count+']"]').val(reasonInject).change();
    $('input[name="_idItem['+count+']"]').val(idItem);
}

//set get  idPaste 
var idPaste ;
function setIdPaste(e){
    idPaste = e.dataset.id;
}

function removeIdPaste(){
    idPaste = null;
};

