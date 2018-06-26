<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{env('APP_NAME')}}</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="/css/admin.css"/>

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
    @stack('styles')
    @if(env('APP_ENV')=='production')
        <script type="text/javascript">
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                        (i[r].q = i[r].q || []).push(arguments)
                    }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

            ga('create', '{{env('GOOGLE_ANALYTICS')}}', 'auto');
            ga('send', 'pageview');
        </script>
    @endif
    <script>
        var curPage = "{{request()->segment(1)}}";
        var CRSF_TOKEN = '{{csrf_token()}}';
    </script>
</head>
<body>

<!--Header-part-->
<div id="header">
    <h1><a href="/dashboard">{{env('APP_NAME')}}</a></h1>
</div>
<!--close-Header-part-->

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-default">
    <ul class="nav">
        <li class="dropdown" id="profile-messages"><a title="" href="#" data-toggle="dropdown"
                                                      data-target="#profile-messages" class="dropdown-toggle"><i
                        class="icon-user"></i> <span class="text">
                    @lang("Welcome")
                    {{Auth::user()->username}}</span><b
                        class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="/account"><i class="icon-home"></i> @lang("My Account")</a></li>
                <li class="divider"></li>
                <li><a href="/profile"><i class="icon-user"></i>
                    @lang("My Profile")
                    </a></li>
                <li class="divider"></li>
                <li class="logout"><a href="#"><i class="icon-key"></i>
                        @lang("Logout")
                    </a></li>
            </ul>
        </li>
        @permission('messages-read')
        <li class="dropdown" id="menu-messages">
            <a href="#" data-toggle="dropdown" data-target="#menu-messages"
               class="dropdown-toggle"><i class="icon-envelope"></i> <span
                        class="text">@lang("Messages")</span> <span
                        class="label label-important">{!! \App\Models\Messaging::whereSender(Auth::user()->id)->count() !!}</span>
                <b class="caret"></b></a>
            <ul class="dropdown-menu">

                @permission('messages-create')
                <li><a class="sAdd" title="" href="/messaging/admin">
                        <i class="icon-plus"></i> @lang("new message")</a></li>
                <li class="divider"></li>
                @endpermission

                <li><a class="sOutbox" title="" href="/messaging/history">
                        <i class="icon-arrow-up"></i> @lang("outbox")</a></li>
                <li class="divider"></li>
                @permission('templates-read')
                <li><a class="sTrash" title="" href="/templates">
                        <i class="icon-th"></i> @lang("templates")</a></li>
                @endpermission
            </ul>
        </li>
        @endpermission

        @role('admin')
        <li class="dropdown" id="menu-messages">
            <a href="#" data-toggle="dropdown" data-target="#menu-messages"
               class="dropdown-toggle"><i class="icon-cog"></i> <span
                        class="text">@lang("Settings")</span>
                <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="/settings"><i class="icon-wrench"></i>
                    @lang("Settings")</a></li>
                <li><a href="/roles"><i class="icon-key"></i> @lang("Roles")
                    </a></li>
                <li><a href="/menu"><i class="icon-list"></i> @lang("Menu")
                    </a></li>
                <li><a href="/theme"><i class="icon-th"></i>@lang("Change theme")</a></li>
                <li><a href="/giving/gift-options"><i class="icon-th"></i> @lang("Gift Options")</a></li>
                <li><a href="/debug-log"><i class="icon-question-sign"></i> @lang("Debug logs")</a></li>
            </ul>
        </li>
        @endrole
        <li class="home">
            <a title="" href="/" target="_blank">
                <i class="icon-external-link"></i>
                <span class="text">@lang("Open site")</span>
            </a>
        </li>
        <li class="kiosk">
            <a title="" href="/kiosk">
                <i class="icon-external-link" style="color:red"></i>
                <span class="text" style="color:red">@lang("Kiosk Mode")</span>
            </a>
        </li>
        <li class="logout">
            <a title="" href="#">
                <i class="icon-share-alt"></i>
                <span class="text">@lang("Logout")</span>
            </a>
        </li>
    </ul>
</div>

{{--<div id="search">--}}
{{--<input type="text" placeholder="Search here..."/>--}}
{{--<button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>--}}
{{--</div>--}}

<!--sidebar-menu-->
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon-info-sign"></i> @lang("Error")</a>
    <ul class="sideNav">
        <li><a href="/dashboard"><i class="icon-home"></i> <span>@lang('Dashboard')</span></a></li>

        <li><a href="/account"><i class="icon-user"></i> <span>@lang("My Account")</span></a></li>

        @permission('read-gifts')
        <li><a href="/giving/gifts"><i class="icon-money"></i> <span>@lang("Gifts")</span></a></li>
        @endpermission

        @permission('read-mail')
        <li><a href="/messaging/admin"><i class="icon-envelope"></i> <span>@lang("Messaging")</span>
                <span class="label label-important">
                    {!! \App\Models\Messaging::whereSender(Auth::user()->id)->count() !!}
                </span></a></li>
        @endpermission

        @permission('read-ministries')
        <li><a href="/ministries/admin"><i class="icon-th"></i> <span>@lang("Ministries")</span></a></li>
        @endpermission

        @permission('read-sermons')
        <li><a href="/sermons/admin"><i class="icon-th"></i> <span>@lang("Sermons")</span></a></li>
        @endpermission

        @permission('read-events')
        <li><a href="/events/admin"><i class="icon-calendar"></i> <span>@lang("Events")</span></a></li>
        @endpermission

        @permission('read-blog')
        <li><a href="/blog/admin"><i class="icon-leaf"></i> <span>@lang("Blog")</span></a></li>
        @endpermission

        @permission('read-users')
        <li><a href="/users"><i class="icon-user"></i> <span>@lang("Users")</span>
                <span class="label label-important">
                  {{\App\User::count()}}
                </span></a>
        </li>
        @endpermission

        @if(\Trust::hasRole('admin'))
            <li><a href="/birthdays"><i class="icon-refresh"></i> <span>@lang("Birthdays")</span></a></li>
            <li><a href="/support/questions"><i class="icon-question-sign"></i> <span>@lang("Support")</span></a></li>
        @else
            <li><a href="/support"><i class="icon-question-sign"></i> <span>@lang("Support")</span></a></li>
        @endif

        @role('admin')
        <li class="submenu">
            <a href="#"><i class="icon icon-cog"></i> <span>@lang("Admin")</span></a>
            <ul>
                <li><a href="/settings"><i class="icon-wrench"></i> @lang("Settings")</a></li>
                <li><a href="/roles"><i class="icon-key"></i> @lang("Roles")</a></li>
                <li><a href="/menu"><i class="icon-list"></i> @lang("Menu")</a></li>
                <li><a href="/theme"><i class="icon-th"></i> @lang("Change themes")</a></li>
                <li><a href="/giving/gift-options"><i class="icon-th"></i> @lang("Gift Options")</a></li>
                <li><a href="/debug-log"><i class="icon-question-sign"></i> @lang("Debug logs")</a></li>
            </ul>
        </li>
        <li><a href="/kiosk"><i class="icon-external-link"></i> <span>@lang("Kiosk Mode")</span></a></li>
        @endrole
    </ul>
</div>
<div id="content">
    <div id="content-header">
        <div id="breadcrumb">
            <a href="/dashboard" title="Dashboard" class="tip-bottom"><i class="icon-home"></i>
            @lang("Dashboard")
            </a>
            @yield('crumbs')
        </div>
        @hasSection('title')
            <h1>
                @yield('title')
            </h1>
        @endif

    </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                @if(Auth::check() && Auth::user()->confirmed ==0)
                    <div class="callout callout-danger text-center text-danger">
                        <i style="font-size:60px;" class="icon-exclamation-triangle"></i>
                        <h5 class="">
                            @lang("Your account is not confirmed yet")
                            @lang("Please follow instructions received on the email").
                        </h5>

                        <a href="/register/confirm">@lang("Click here to resend confirmation email")</a>

                    </div>
                @else
                    @yield('content')
                @endif
            </div>
        </div>
    </div>
</div>
<!--Footer-part-->
<div class="row-fluid">
    <div id="footer" class="span12">
        &copy; {{date('Y')}} <a href="https://amdtllc.com">A&M Digital Technologies</a>
    </div>
</div>
<!--end-Footer-part-->
<script src="/js/jquery.min.js"></script>
<script src="/js/app.js"></script>

@include('partials.flash')

<script src="/js/global.js"></script>

@stack('scripts')
@stack('modals')
</body>
</html>
