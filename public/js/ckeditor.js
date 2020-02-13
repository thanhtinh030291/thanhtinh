$(function(){
    $('.editor_default').each(function(e){
        CKEDITOR.replace( this.id);
    });
});