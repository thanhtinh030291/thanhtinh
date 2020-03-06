@php
$langs = config('constants.lang');
$min = config('constants.minMaxLength.min');
$max = config('constants.minMaxLength.max');
@endphp
@extends('layouts.admin.master')
@section('title', 'Message')
@section('stylesheets')
<link rel="stylesheet" type="text/css" href="{{asset('css/jquery-ui.min.css')}}">
<link href="{{ asset('css/multi_lang.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/chat.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/icheck.css') }}" media="all" rel="stylesheet" type="text/css"/>

@endsection
@section('content')
@include('layouts.admin.breadcrumb_index', [
    'title'       => 'Messagebox' ,
    'parent_url'  => route('home'),
    'parent_name' => "Home",
    'page_name'   => 'Messagebox',
])
<section class="content">
    <div class="row">
    <div class="col-md-3">
        <a href="compose.html" class="btn btn-primary btn-block margin-bottom">Compose</a>

        <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Folders</h3>
        </div>
        <div class="box-body p-0">
            <ul class="nav nav-pills nav-stacked">
            <li><a href="#"><i class="fa fa-inbox"></i> Inbox
                <span class="label label-primary pull-right">12</span></a></li>
            <li><a href="#"><i class="fa fa-envelope-o"></i> Sent</a></li>
            <li><a href="#"><i class="fa fa-file-text-o"></i> Drafts</a></li>
            <li><a href="#"><i class="fa fa-filter"></i> Junk <span class="label label-warning pull-right">65</span></a>
            </li>
            <li><a href="#"><i class="fa fa-trash-o"></i> Trash</a></li>
            </ul>
        </div>
        <!-- /.box-body -->
        </div>
        <!-- /. box -->
        <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Labels</h3>
        </div>
        <div class="box-body p-0" >
            <ul class="nav nav-pills nav-stacked">
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> Important</a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> Promotions</a></li>
            <li><a href="#"><i class="fa fa-circle-o text-light-blue"></i> Social</a></li>
            </ul>
        </div>
        <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Inbox</h3>

            <div class="box-tools pull-right">
            <div class="has-feedback">
                <input type="text" class="form-control input-sm" placeholder="Search Mail">
                <span class="glyphicon glyphicon-search form-control-feedback"></span>
            </div>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
            <div class="mailbox-controls">
            <!-- Check all button -->
            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
            </button>
            <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
            </div>
            <!-- /.btn-group -->
            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
            <div class="pull-right">
                1-50/200
                <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                </div>
                <!-- /.btn-group -->
            </div>
            <!-- /.pull-right -->
            </div>
            <div class="table-responsive mailbox-messages">
            <table class="table table-hover table-striped">
                <tbody>
                    @foreach ($messages as $item)
                    <tr>
                        <td><div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                        <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                        <td class="mailbox-name"><a href="read-mail.html">{{data_get($admin_list, $item->user_from)}}</a></td>
                        <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to this problem...
                        </td>
                        <td class="mailbox-attachment"></td>
                        <td class="mailbox-date">5 mins ago</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- /.table -->
            </div>
            <!-- /.mail-box-messages -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer no-padding">
            <div class="mailbox-controls">
            <!-- Check all button -->
            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
            </button>
            <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
            </div>
            <!-- /.btn-group -->
            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
            <div class="pull-right">
                1-50/200
                <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                </div>
                <!-- /.btn-group -->
            </div>
            <!-- /.pull-right -->
            </div>
        </div>
        </div>
        <!-- /. box -->
    </div>
    <!-- /.col -->
    </div>
    <!-- /.row -->
</section>

@endsection
@section('scripts')
<script src="{{ asset('plugins/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('js/tinymce.js') }}"></script>
<script src="{{ asset('js/icheck.min.js') }}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(function () {
        //Enable iCheck plugin for checkboxes
        //iCheck for checkbox and radio inputs
        $('.mailbox-messages input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
        });

        //Enable check and uncheck all functionality
        $(".checkbox-toggle").click(function () {
        var clicks = $(this).data('clicks');
        if (clicks) {
            //Uncheck all checkboxes
            $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
            $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
        } else {
            //Check all checkboxes
            $(".mailbox-messages input[type='checkbox']").iCheck("check");
            $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
        }
        $(this).data("clicks", !clicks);
        });

        //Handle starring for glyphicon and font awesome
        $(".mailbox-star").click(function (e) {
        e.preventDefault();
        //detect type
        var $this = $(this).find("a > i");
        var glyph = $this.hasClass("glyphicon");
        var fa = $this.hasClass("fa");

        //Switch states
        if (glyph) {
            $this.toggleClass("glyphicon-star");
            $this.toggleClass("glyphicon-star-empty");
        }

        if (fa) {
            $this.toggleClass("fa-star");
            $this.toggleClass("fa-star-o");
        }
        });
    });
</script>
@endsection
