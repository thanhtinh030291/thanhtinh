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