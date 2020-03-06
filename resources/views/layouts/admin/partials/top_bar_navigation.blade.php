<!-- Stored in resources/views/dashboard.blade.php -->
<div class="headerbar">
    <!-- LOGO -->
    <div class="headerbar-left">
        <a href="{{ url('') }}" class="logo"><img style="width:45px" alt="Logo" src="{{asset('images/logo.png')}}" /> <span style="color: #0C4588">Claim Assistant</span></a>
    </div>

    <nav class="navbar-custom">
        <ul class="list-inline float-right mb-0">

            <li class="list-inline-item dropdown notif">
                <a class="nav-link" href="/docs" role="button" aria-haspopup="false" aria-expanded="false">
                    Documents
                </a>
            </li>
            <li class="list-inline-item" id='checkbox-notify'>
                <i class="fa fa-bell text-warning" style="font-size: x-large;" aria-hidden="true"></i>
                <label class=" m-0 p-2 switch">
                    <input type="checkbox" onchange="onOffpush(this)" checked>
                    <span class="slider round"></span>
                </label>
            </li>
            
            <li class="list-inline-item dropdown notif dropdown-notifications">
                <a href="#notifications-panel" class="dropdown-toggle" data-toggle="dropdown">
                    <i data-count="{{count($messages)}}" class="fa fa-envelope notification-icon text-warning"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown dropdown-notifications">
                    <div class="dropdown-toolbar">
                        <div class="dropdown-toolbar-actions">
                            <a href="#" onclick="readAllMessages()">Mark all as read</a>
                        </div>
                    <h3 class="dropdown-toolbar-title">Notifications (<span class="notif-count">{{count($messages)}}</span>)</h3>
                    </div>
                    <ul class="dropdown-menu-notifi" style = " max-height: 300px; overflow: hidden; overflow-y: scroll;">
                        @foreach ($messages as $item)
                            <li class="notification active">
                                <div class="media">
                                    <div class="media-left">
                                    <div class="media-object">
                                        <img src="https://api.adorable.io/avatars/71/`+avatar+`.png" class="img-circle" alt="50x50" style="width: 50px; height: 50px;">
                                    </div>
                                    </div>
                                    <div class="media-body">
                                    <strong class="notification-title">{{$item->userFrom->email}}</strong>
                                    <p class="notification-desc">{{$item->message}}</p>
                                    <div class="notification-meta">
                                        <small class="timestamp">{{dateConvertToString($item->created_at)}}</small>
                                    </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="dropdown-footer text-center">
                        <a href="/admin/message">View All</a>
                    </div>
                </div>
            </li>
            <li class="list-inline-item dropdown notif">
                <a class="nav-link dropdown-toggle nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="{{asset('images/avatars/admin.png')}}" alt="Profile image" class="avatar-rounded">
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->
                    <div class="dropdown-item noti-title">
                        <h5 class="text-overflow"><small>{{__('message.hello')}}, {{ Auth::user()->name }}</small> </h5>
                    </div>

                    <!-- item-->
                    <a class="dropdown-item notify-item" href="{{ route('MyProfile') }}" >
                        <span>My Profile</span>
                    </a>
                    <a class="dropdown-item notify-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-power-off"></i> <span>{{ __('message.logout') }}</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
            
        </ul>

        <ul class="list-inline menu-left mb-0">
            <li class="float-left">
                <button class="button-menu-mobile open-left">
                    <i style = "display: block !important" class="fa fa-fw fa-bars"></i>
                </button>
            </li>
        </ul>
    </nav>
</div>
