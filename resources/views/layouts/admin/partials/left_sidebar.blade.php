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
                            href="{{ url('admin/claim') }}"><span> {{ __('message.form_claim_ocr')}}</span></a>
                        </li>
                        <li class="{{ setActive('admin/reason_reject') }}"> 
                            <a class="{{ setActive('admin/reason_reject') }}"
                            href="{{ url('admin/reason_reject') }}"><span> {{ __('message.reason_reject')}}</span></a>
                        </li>
                        <li class="{{ setActive('admin/product') }}"> 
                            <a class="{{ setActive('admin/product') }}"
                            href="{{ url('admin/product') }}"><span> {{ __('message.product')}}</span></a>
                        </li>
                        <li class="{{ setActive('admin/term') }}"> 
                            <a class="{{ setActive('admin/term') }}"
                            href="{{ url('admin/term') }}"><span> {{ __('message.term')}}</span></a>
                        </li>
                        <li class="{{ setActive('admin/letter_template') }}"> 
                            <a class="{{ setActive('admin/letter_template') }}"
                            href="{{ url('admin/letter_template') }}"><span> {{ __('message.letter_template')}}</span></a>
                        </li>
                    </ul>
                </li>
                {{-- UNC Sign --}}
                @hasanyrole('Header|Manager|Admin')
                <li class="submenu">
                    <a href="#">
                        <i class="fa fa-pencil-square" aria-hidden="true"></i> <span> Sign UNC </span>
                    </a>
                    <ul class="list-unstyled">
                        <li class="{{ setActive('admin/uncSign') }}"> 
                            <a class="{{ setActive('admin/uncSign') }}"
                            href="{{ url('admin/uncSign') }}"><span> Sign UNC</span></a>
                        </li>
                    </ul>
                </li>
                @endhasanyrole
                {{-- Medical --}}
                <li class="submenu">
                    <a href="#">
                        <i class="fa fa-medkit" aria-hidden="true"></i> <span> Medical Management </span>
                    </a>
                    <ul class="list-unstyled">
                        <li class="{{ setActive('admin/claimWordSheets') }}"> 
                            <a class="{{ setActive('admin/claimWordSheets') }}"
                            href="{{ url('admin/claimWordSheets') }}"><span> Q&A Of Claim</span></a>
                        </li>
                    </ul>
                </li>
                {{-- Support Tool --}}
                <li class="submenu">
                    <a href="#">
                        <i class="fa fa-calculator" aria-hidden="true"></i> <span> Support Tool </span>
                    </a>
                    <ul class="list-unstyled">
                        <li class="{{ setActive('admin/roomAndBoards') }}"> 
                            <a class="{{ setActive('admin/roomAndBoards') }}"
                            href="{{ url('admin/roomAndBoards') }}"><span> Room & Board</span></a>
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
                        <li class="{{ setActive('admin/permiss') }}">
                            <a  class="{{ setActive('admin/permiss') }}" href="{{ url('admin/permiss') }}">
                            <span> Permission Managerment</span></a>
                        </li>
                        <li class="{{ setActive('admin/roleChangeStatuses') }}">
                            <a  class="{{ setActive('admin/roleChangeStatuses') }}" href="{{ url('admin/roleChangeStatuses') }}">
                            <span> List Status Approved</span></a>
                        </li>
                        <li class="{{ setActive('admin/levelRoleStatuses') }}">
                            <a  class="{{ setActive('admin/levelRoleStatuses') }}" href="{{ url('admin/levelRoleStatuses') }}">
                            <span> List Level Approved</span></a>
                        </li>
                        <li class="{{ setActive('admin/transactionRoleStatuses') }}">
                            <a  class="{{ setActive('admin/transactionRoleStatuses') }}" href="{{ url('admin/transactionRoleStatuses') }}">
                            <span> Transaction Approved</span></a>
                        </li>
                        <li class="{{ setActive('admin/setting') }}">
                            <a  class="{{ setActive('admin/setting') }}" href="{{ url('admin/setting') }}">
                            <span> Setting App</span></a>
                        </li>
                    </ul>
                </li>
                @endrole
            </ul>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
