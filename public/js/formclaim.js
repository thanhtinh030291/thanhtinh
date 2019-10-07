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
    
    switch (value) {
        case 'amount':
        case 'price_unit':
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
        default:
            arrElemt.removeClass("item-price");
            break;
    }
}