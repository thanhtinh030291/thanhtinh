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
        "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
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
        editor.addButton("mybutton", {
            text: "My button",
            icon: false,
            onclick: function() {
                editor.insertContent("&nbsp;<b>It's my button!</b>&nbsp;");
            }
        });
    }
};

var config2 = {
    selector: "textarea",
    height: 500,
    toolbar: "nameItem | amountItem | Date | Example | insertfile undo redo | paste | copy",
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
        editor.addButton("Example", {
            text: "Example",
            icon: false,
            onclick: function() {
                editor.insertContent("<br>Chi phí &nbsp;<b class = 'text-danger'>[##nameItem##]</b>&nbsp; . (<b class = 'text-danger'>[##amountItem##]</b> đồng)  , không được thanh toán do thuộc điều khoản loại trừ mục 3.6 Quy tắc và Điều khoản bảo hiểm Chăm sóc sức khỏe.");
            }
        });
    }
};
tinymce.init(config2);
