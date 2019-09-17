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
                        <i class="fa fa-fw fa-ticket"></i> <span> {{__('message.scanner_OCR')}} </span>
                    </a>
                    <ul class="list-unstyled">
                        <li class="{{ setActive('admin/google_cloud_vision') }}">
                            <a class="{{ setActive('admin/google_cloud_vision') }}"
                            href="{{ url('admin/google_cloud_vision') }}"><span> {{ __('message.google_cloud_vision_API')}}</span></a>
                        </li>
                        <li class="{{ setActive('admin/google_cloud_vision') }}">
                            <a class="{{ setActive('admin/google_cloud_vision') }}"
                            href="{{ url('admin/google_cloud_vision') }}"><span> {{ __('message.abbyy')}}</span></a>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
