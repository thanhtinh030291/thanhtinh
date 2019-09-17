function loadDatepicker() {
    $(".datepicker").daterangepicker({
            locale: {
            "format": "YYYY-MM-DD"
        },
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
    });
    $(".datepicker").on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD'));
    });
    $(".datepicker").on('change', function() {
        var date = moment($(this).val(), 'YYYY-MM-DD', true);
        if (!date.isValid()) {
            $(this).val('');
        }
    });
}
$(document).ready(function() {
    loadDatepicker();
});

