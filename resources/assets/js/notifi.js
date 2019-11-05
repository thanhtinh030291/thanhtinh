
let token = document.head.querySelector('meta[name="csrf-token"]');
const USER_ID = Number($('meta[name=user_id]').attr("content"));
import Echo from 'laravel-echo';

window.io = require('socket.io-client');
window.Echo = new Echo({
    namespace: 'App.Events',
    broadcaster: 'socket.io',
    host: `${window.location.hostname}:9090`
});

window.Echo.channel('user.'+USER_ID)
    .listen('Notify', (e) => {
        console.log(e);
        pusher(e);
        //$('#content').append(`<div class="well">${e.message}</div>`);
    });

