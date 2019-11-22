var editor_config = {
    language: "en",
    path_absolute: "/",
    selector: "textarea.editor",
    branding: false,
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar:
          
            ["insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            "applicantName | IOPDiag | PRefNo | PhName | PRefNo | memberNameCap | ltrDate | pstAmt | apvAmt | payMethod | deniedAmt | CSRRemark | TermRemark"]
        ,
    relative_urls: false,
    file_browser_callback: function(field_name, url, type, win) {
        var x =
            window.innerWidth ||
            document.documentElement.clientWidth ||
            document.getElementsByTagName("body")[0].clientWidth;
        var y =
            window.innerHeight ||
            document.documentElement.clientHeight ||
            document.getElementsByTagName("body")[0].clientHeight;

        var cmsURL =
            editor_config.path_absolute +
            "laravel-filemanager?field_name=" +
            field_name;
        if (type == "image") {
            cmsURL = cmsURL + "&type=Images";
        } else {
            cmsURL = cmsURL + "&type=Files";
        }

        tinyMCE.activeEditor.windowManager.open({
            file: cmsURL,
            title: "Filemanager",
            width: x * 0.8,
            height: y * 0.8,
            resizable: "yes",
            close_previous: "no"
        });
    },
    setup: function(editor) {
        editor.addButton("applicantName", {
            text: "Applicant Name",
            icon: false,
            onclick: function() {
                editor.insertContent("&nbsp;[[$applicantName]]&nbsp;");
            }
        });
        editor.addButton("IOPDiag", {
            text: "IOPDiag",
            icon: false,
            onclick: function() {
                editor.insertContent("&nbsp;[[$IOPDiag]]&nbsp;");
            }
        });
        editor.addButton("PRefNo", {
            text: "PRefNo",
            icon: false,
            onclick: function() {
                editor.insertContent("&nbsp;[[$PRefNo]]&nbsp;");
            }
        });
        editor.addButton("PhName", {
            text: "PhName",
            icon: false,
            onclick: function() {
                editor.insertContent("&nbsp;[[$PhName]]&nbsp;");
            }
        });
        editor.addButton("memberNameCap", {
            text: "memberNameCap",
            icon: false,
            onclick: function() {
                editor.insertContent("&nbsp;[[$memberNameCap]]&nbsp;");
            }
        });

        editor.addButton("ltrDate", {
            text: "ltrDate",
            icon: false,
            onclick: function() {
                editor.insertContent("&nbsp;[[$ltrDate]]&nbsp;");
            }
        });

        editor.addButton("pstAmt", {
            text: "pstAmt",
            icon: false,
            onclick: function() {
                editor.insertContent("&nbsp;[[$pstAmt]]&nbsp;");
            }
        });

        editor.addButton("apvAmt", {
            text: "apvAmt",
            icon: false,
            onclick: function() {
                editor.insertContent("&nbsp;[[$apvAmt]]&nbsp;");
            }
        });

        editor.addButton("payMethod", {
            text: "payMethod",
            icon: false,
            onclick: function() {
                editor.insertContent("&nbsp;[[$payMethod]]&nbsp;");
            }
        });

        editor.addButton("deniedAmt", {
            text: "deniedAmt",
            icon: false,
            onclick: function() {
                editor.insertContent("&nbsp;[[$deniedAmt]]&nbsp;");
            }
        });

        editor.addButton("CSRRemark", {
            text: "CSRRemark",
            icon: false,
            onclick: function() {
                editor.insertContent("&nbsp;[[$CSRRemark]]&nbsp;");
            }
        });

        editor.addButton("TermRemark", {
            text: "TermRemark",
            icon: false,
            onclick: function() {
                editor.insertContent("&nbsp;[[$TermRemark]]&nbsp;");
            }
        });
        
    }
};
tinymce.init(editor_config);


////type 2
var config2 = {
    selector: "textarea.editor2",
    height: 500,
    toolbar: "nameItem | amountItem | Date | Text | Begin | End | Example | insertfile undo redo | paste | copy",
    plugins: "wordcount",
    menubar: false,
    content_css: [
        "//fonts.googleapis.com/css?family=Lato:300,300i,400,400i",
        "//www.tinymce.com/css/codepen.min.css",
        'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'
    ],

    setup: function(editor) {
        editor.addButton("nameItem", {
            text: "Name Item",
            icon: false,
            onclick: function() {
                editor.insertContent("&nbsp;<b class = 'text-danger'>[##nameItem##]</b>&nbsp;");
            }
        });
        editor.addButton("amountItem", {
            text: "Amount Item",
            icon: false,
            onclick: function() {
                editor.insertContent("&nbsp;<b class = 'text-danger'>[##amountItem##]</b>&nbsp;");
            }
        });
        editor.addButton("Date", {
            text: "Date",
            icon: false,
            onclick: function() {
                editor.insertContent("&nbsp;<b class = 'text-danger'>[##Date##]</b>&nbsp;");
            }
        });
        editor.addButton("Text", {
            text: "Text",
            icon: false,
            onclick: function() {
                editor.insertContent("&nbsp;<b class = 'text-danger'>[##Text##]</b>&nbsp;");
            }
        });
        editor.addButton("Begin", {
            text: "Begin",
            icon: false,
            onclick: function() {
                editor.insertContent("&nbsp;<b class = 'text-danger'>[Begin]</b>&nbsp;");
            }
        });
        editor.addButton("End", {
            text: "End",
            icon: false,
            onclick: function() {
                editor.insertContent("&nbsp;<b class = 'text-danger'>[End]</b>&nbsp;");
            }
        });
        editor.addButton("Example", {
            text: "Example",
            icon: false,
            onclick: function() {
                editor.insertContent("<br>Chi phí &nbsp;<b class = 'text-danger'>[##nameItem##]</b>&nbsp; từ ngày &nbsp;<b class = 'text-danger'>[##Date##]</b>&nbsp; đến &nbsp;<b class = 'text-danger'>[##Date##]</b>&nbsp; là &nbsp;<b class = 'text-danger'>[##amountItem##]</b>&nbsp; , tuy nhiên công ty Bảo hiểm Dai-ichi Life Việt Nam từ chối chi trả &nbsp;<b class = 'text-danger'>[##Text##]</b>&nbsp; đồng do vượt mức quyền lợi tối đa( &nbsp;<b class = 'text-danger'>[##Text##]</b>&nbsp; đồng/ ngày x &nbsp;<b class = 'text-danger'>[##Text##]</b>&nbsp; = &nbsp;<b class = 'text-danger'>[##Text##]</b>&nbsp; đồng).");
            }
        });
    }
};
tinymce.init(config2);

//default
var config3 = {
    selector: "textarea.editor_default",
    height: 500,
    toolbar: " insertfile undo redo | paste | copy",
    plugins: "wordcount",
    menubar: false,
    content_css: [
        "//fonts.googleapis.com/css?family=Lato:300,300i,400,400i",
        "//www.tinymce.com/css/codepen.min.css",
        'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'
    ],

    
};
tinymce.init(config3);
