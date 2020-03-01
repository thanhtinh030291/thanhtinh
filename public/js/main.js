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

function loadDateTimePicker() {
    $(".datetimepicker").daterangepicker({
        timePicker: true,
        timePicker24Hour: true,
        timePickerIncrement: 1,
        locale: {
            format: 'DD/MM/YYYY HH:mm'
        }
    });
    
}

$(document).ready(function() {
    loadDatepicker();
    loadDateTimePicker();
});

function pusher_res(data){
    var notificationsWrapper   = $('.dropdown-notifications');
    var notificationsToggle    = notificationsWrapper.find('a[data-toggle]');
    var notificationsCountElem = notificationsToggle.find('i[data-count]');
    var notificationsCount     = parseInt(notificationsCountElem.data('count'));
    var notifications          = notificationsWrapper.find('ul.dropdown-menu-notifi');

    // Enable pusher logging - don't include this in production
    
    
        var existingNotifications = notifications.html();
        var avatar = Math.floor(Math.random() * (71 - 20 + 1)) + 20;
        var newNotificationHtml = `
            <li class="notification active">
                <div class="media">
                    <div class="media-left">
                    <div class="media-object">
                        <img src="https://api.adorable.io/avatars/71/`+avatar+`.png" class="img-circle" alt="50x50" style="width: 50px; height: 50px;">
                    </div>
                    </div>
                    <div class="media-body">
                    <strong class="notification-title">`+data.title+`</strong>
                    <p class="notification-desc">`+data.message+`</p>
                    <div class="notification-meta">
                        <small class="timestamp">about a minute ago</small>
                    </div>
                    </div>
                </div>
            </li>
        `;
        notifications.html(newNotificationHtml + existingNotifications);

        notificationsCount += 1;
        console.log(notificationsCount);
        notificationsCountElem.attr('data-count', notificationsCount);
        notificationsWrapper.find('.notif-count').text(notificationsCount);
        notificationsWrapper.show();
        $.notify({
            icon: 'fa fa-bell',
            title: '<strong>'+data.title+'</strong>',
            message: data.message
        },{
            placement: {
                from: "bottom",
                align: "right"
            },
            type: 'success'
        });
}

function readAllMessages(){
    
    $.ajax({
        url: "/admin/read_all_messages",
        type: 'POST',
        
    })
    .done(function(res) {
        var notificationsWrapper   = $('.dropdown-notifications');
        var notificationsToggle    = notificationsWrapper.find('a[data-toggle]');
        var notificationsCountElem = notificationsToggle.find('i[data-count]');
        var notificationsCount     = parseInt(notificationsCountElem.data('count'));
        var notifications          = notificationsWrapper.find('ul.dropdown-menu-notifi');
        notifications.html("");
        var notificationsWrapper   = $('.dropdown-notifications');
        notificationsCountElem.attr('data-count', "0");
        notificationsWrapper.find('.notif-count').text('0');

    })
}
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

