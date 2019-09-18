<!-- Stored in resources/views/dashboard.blade.php -->
<div class="headerbar">
    <!-- LOGO -->
    <div class="headerbar-left">
        <a href="{{ url('') }}" class="logo"><img style="width:50px" alt="Logo" src="{{asset('images/logo.png')}}" /> <span style="color: #0C4588">PACIFIC CROSS</span></a>
    </div>

    <nav class="navbar-custom">
        <ul class="list-inline float-right mb-0">
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
