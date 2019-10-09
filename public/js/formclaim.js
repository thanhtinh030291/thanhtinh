function showTiff(file) {
    $('#list-page').empty();
    var reader = new FileReader();
    reader.onload = (function (theFile) {
        return function (e) {
            var buffer = e.target.result;
            var tiff = new Tiff({buffer: buffer});
            //var canvas = tiff.toCanvas();
            //var width = tiff.width();
            //var height = tiff.height();
            //if (canvas) {
            //  $('#page').empty().append(canvas);
            //}
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
    console.log(e.dataset.id);
    selectpage = e.dataset.id;
    showTiff(trialImage);
}

function clickGo(){
    var text = $("#select-inject-default option:selected").text();
    var arrElementcheck = $('.checkbox_class');
    $.each(arrElementcheck, function (index, value) {
        var id = value.dataset.id;
        if(value.checked){
            $('#btnConfirm'+id).show();
            $('#btnConfirm'+id).attr("title",text);
            $('#inputReject'+id).prop("checked", false);
            $('#reason'+id).val(text);
        }
    });
};

function checkAll(e){
    console.log(e.checked);
    $(".checkbox_class").prop("checked", e.checked);
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
        case 'unit_price':
            {   
                arrElemt.addClass("item-price");
                arrElemt.val().replace(".",",");
                var arrayElement = document.getElementsByClassName('item-price');
                $.each(arrayElement, function (index, value) {
                    var st = $(this).val().replace(".", ",");
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
        case 'quantity':
            {

                $.each(arrElemt, function (index, value) {
                    var patt1 = /^\d$/gm;
                    var is_valid = patt1.test($(this).val());
                    if (is_valid) {
                        $(this).removeClass('invalid');
                        $(this).addClass('valid');
                    } else {
                        $(this).removeClass('valid');
                        $(this).addClass('invalid');
                    }
                });
            }
            break;
        case 'content':
            {
                arrElemt.addClass("item-content");
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