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
                        <li class="{{ setActive('admin/claim') }}"> 
                            <a class="{{ setActive('admin/claim') }}"
                            href="{{ url('admin/claim') }}"><span> {{ __('message.form_claim_orc')}}</span></a>
                        </li>
                        <li class="{{ setActive('admin/list_reason_inject') }}"> 
                            <a class="{{ setActive('admin/list_reason_inject') }}"
                            href="{{ url('admin/list_reason_inject') }}"><span> {{ __('message.list_reason_inject')}}</span></a>
                        </li>
                        <li class="{{ setActive('admin/product') }}"> 
                            <a class="{{ setActive('admin/product') }}"
                            href="{{ url('admin/product') }}"><span> {{ __('message.product')}}</span></a>
                        </li>
                        <li class="{{ setActive('admin/term') }}"> 
                            <a class="{{ setActive('admin/term') }}"
                            href="{{ url('admin/term') }}"><span> {{ __('message.term')}}</span></a>
                        </li>
                    </ul>
                </li>
                @role('Admin')
                <li class="submenu">
                    <a href="#">
                        <i class="fa fa-cogs" aria-hidden="true"></i> <span> System Management </span>
                    </a>
                    <ul class="list-unstyled">
                        <li class="{{ setActive('admin/importExportView') }}"> 
                            <a class="{{ setActive('admin/importExportView') }}"
                            href="{{ url('admin/importExportView') }}"><span> Import & Export  DB</span></a>
                        </li>
                        <li class="{{ setActive('admin/admins') }}">
                            <a  class="{{ setActive('admin/admins') }}" href="{{ url('admin/admins') }}">
                            <span> {{ __('message.staff_management')}}</span></a>
                        </li>
                        <li class="{{ setActive('admin/role') }}">
                            <a  class="{{ setActive('admin/role') }}" href="{{ url('admin/role') }}">
                            <span> {{ __('message.role_management')}}</span></a>
                        </li>
                    </ul>
                </li>
                @endrole
            </ul>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
