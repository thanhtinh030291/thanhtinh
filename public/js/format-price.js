function formatPrice(x) {
    //remove format first
    x = removeFormatPrice(x);
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}
function removeFormatPrice(number) {
    number = number.toString();
    var result = number.replace(/,/g, '');
    result = result.replace(/[^0-9|.]+/g, '');
    return result;
}
function changeFormatObj(obj) {
    var formated = formatPrice(obj.val());
    obj.val(formated);
}
$(document).on("keyup", '.item-price', function(){
    changeFormatObj($(this));
});
$(document).ready(function() {
    $('.item-price').each(function(){
        changeFormatObj($(this));
    });
});