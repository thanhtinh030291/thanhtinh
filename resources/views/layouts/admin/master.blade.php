<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="{{ config('app.name') }}">
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="ws_url" content="http://localhost:3000/">
    <meta name="user_id" content="{{ Auth::id() }}">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}">

    <!-- Bootstrap CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Font Awesome CSS -->
    <link href="{{asset('font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Custom CSS -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css" />

	<!-- Date range picker CSS -->
	<link href="{{asset('plugins/datetimepicker/css/daterangepicker.css')}}" rel="stylesheet" />
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/select2_optimize.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/bootstrap-notifications.css')}}" rel="stylesheet" type="text/css" />
    
    @yield('stylesheets')

</head>

<body class="adminbody">
    <div class="loader"></div>
    <div id="main">
        <!-- top bar navigation -->
        @include('layouts.admin.partials.top_bar_navigation',[
            'messages' => $messages,
            
        ])
        <!-- End Navigation -->
        <!-- Left Sidebar -->
        @include('layouts.admin.partials.left_sidebar')
        <!-- End Sidebar -->
        <div class="content-page">
            <!-- Start content -->
            <div class="content">
			    <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12">
                            @include('message.message')
                        </div>
                    </div>
                    @yield('content')
                </div>
            </div>
            <!-- END content -->
        </div>
        <!-- END content-page -->
        <!-- Start footer -->
        @include('layouts.admin.partials.footer')
        <!-- END footer -->
    </div>
    <!-- END main -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="{{asset('js/modernizr.min.js')}}"></script>
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/detect.js')}}"></script>
    <script src="{{asset('js/fastclick.js')}}"></script>
    <script src="{{asset('js/jquery.blockUI.js')}}"></script>
    <script src="{{asset('js/jquery.nicescroll.js')}}"></script>
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/daterangepicker.js')}}"></script>
    <script src="{{asset('js/jquery.cookie.js')}}"></script>
    <!-- App js -->
    <script src="{{asset('js/pikeadmin.js')}}"></script>
    <script src="{{asset('js/pusher.min.js')}}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-notify.min.js') }}"></script>
    <script src="https://js.pusher.com/5.1/pusher.min.js"></script>
    <script src="{{asset('js/main.js')}}"></script>
    
    
    
    
    <script>
        $(window).on("load", function() {
            $(".loader").fadeOut("slow");
        });
        $(document).ready(function(){
            $('.select2').select2();
            //pusher("{{config('broadcasting.connections.pusher.key')}}","{{config('broadcasting.connections.pusher.options.cluster')}}", "{{ Auth::user()->id }}");
        });
        var notificationsWrapper   = $('.dropdown-notifications');
        var notificationsToggle    = notificationsWrapper.find('a[data-toggle]');
        var notificationsCountElem = notificationsToggle.find('i[data-count]');
        var notificationsCount     = parseInt(notificationsCountElem.data('count'));
        var notifications          = notificationsWrapper.find('ul.dropdown-menu');


        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('{{config("constants.PUSHER_APP_KEY")}}', {
            cluster: '{{config("constants.PUSHER_APP_CLUSTER")}}',
            encrypted: true
        });

        // Subscribe to the channel we specified in our Laravel Event
        var channel = pusher.subscribe('NotifyUser-{{ Auth::user()->id }}');
        channel.bind('Notify', function(data) {
            pusher_res(data);
        });

        //Bind a function to a Event (the full Laravel class)

function sendNotification(){
    var data = new FormData();
    data.append('title', document.getElementById('title').value);
    data.append('body', document.getElementById('body').value);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', "{{url('/api/send-notification/'.auth()->user()->id)}}", true);
    xhr.onload = function () {
    // do something to response
    console.log(this.responseText);
    };
    xhr.send(data);
}

var _registration = null;

function registerServiceWorker() {
    return navigator.serviceWorker.register('/js/service-worker.js')
    .then(function(registration) {
    console.log('Service worker successfully registered.');
    _registration = registration;
    return registration;
    })
    .catch(function(err) {
    console.error('Unable to register service worker.', err);
    });
}

function askPermission() {
    return new Promise(function(resolve, reject) {
    const permissionResult = Notification.requestPermission(function(result) {
    resolve(result);
    });
    if (permissionResult) {
    permissionResult.then(resolve, reject);
    }
    })
    .then(function(permissionResult) {
    if (permissionResult !== 'granted') {
    throw new Error('We weren\'t granted permission.');
    }
    else{
    subscribeUserToPush();
    }
    });
}
function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
    .replace(/\-/g, '+')
    .replace(/_/g, '/');
    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);
    for (let i = 0; i < rawData.length; ++i) {
    outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

function getSWRegistration(){
    var promise = new Promise(function(resolve, reject) {
// do a thing, possibly async, then…
        if (_registration != null) {
        resolve(_registration);
        }
        else {
        reject(Error("It broke"));
        }
    });
    return promise;
}

function subscribeUserToPush() {
    getSWRegistration()
    .then(function(registration) {
        console.log(registration);
        const subscribeOptions = {
        userVisibleOnly: true,
        applicationServerKey: urlBase64ToUint8Array(
        '{{ config("constants.VAPID_PUBLIC_KEY") }}'
        )
        };
        return registration.pushManager.subscribe(subscribeOptions);
    })
    .then(function(pushSubscription) {
    console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
    sendSubscriptionToBackEnd(pushSubscription);
    return pushSubscription;
    });
}

function sendSubscriptionToBackEnd(subscription) {
    var response;
    subscription = JSON.parse(JSON.stringify(subscription))
    console.log(subscription.keys.auth);
    $.ajax({
        url: '/subscriptions',
        type: 'POST',
        context: this,
        data: {'endpoint' : subscription.endpoint , 
                'publicKey' : subscription.keys.p256dh ,
                'contentEncoding' : 'aes128gcm',
                'authToken' : subscription.keys.auth
        },
    })
    .done(function(res) {
        response = res;
    })
    return response;
}

function enableNotifications(){
//register service worker
//check permission for notification/ask
    askPermission();
}

if('serviceWorker' in navigator && (location.protocol != 'http' || location.hostname === "localhost")){
    registerServiceWorker();
}else{
    $("#checkbox-notify").hide();
}

function onOffpush(e){
    if(e.checked == false){

    }else{
        subscribeUserToPush();     
    }
}
        
    </script>
    <!-- BEGIN Java Script for this page -->
    @yield('scripts')
    <!-- END Java Script for this page -->
</body>
</html>
