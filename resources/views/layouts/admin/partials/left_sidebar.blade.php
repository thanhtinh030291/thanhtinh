<!-- Stored in resources/views/layouts/admin/partials/left_sidebar.blade.php -->
<div class="left main-sidebar">
    <div class="sidebar-inner leftscroll">
        <div id="sidebar-menu">
            <ul>
                <li class="submenu">
                    <a  class="{{ setActive('home') }}"
                    href="{{ url('admin/home')}}"><i class="fa fa-fw fa-home"></i><span> {{ __('message.home')}} </span> </a>
                </li>
                <li class="submenu">
                    <a href="#">
                        <i class="fa fa-fw fa-ticket"></i> <span> {{__('message.claim_management')}} </span>
                    </a>
                    <ul class="list-unstyled">
                        <li class="{{ setActive('admin/form_claim') }}"> 
                            <a class="{{ setActive('admin/form_claim') }}"
                            href="{{ url('admin/form_claim') }}"><span> {{ __('message.form_claim_orc')}}</span></a>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
