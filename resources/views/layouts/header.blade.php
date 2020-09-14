<title>爱的小巢</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link href="{{ asset('layer/theme/default/layer.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('nova/vendor/nova-icons/nova-icons.css') }}">

<!-- CSS Nova Template -->
<link rel="stylesheet" href="{{asset('nova/css/theme.css')}}">

@yield('style')
<div>
    @if(!Auth::guest())
    <div class="bg-mute row">
        <div class="col-2 text-left">
            <h3 class="mx-5 mt-2 font-weight-bold">爱的小巢</h3>
        </div>
        <div class="col-9 text-center"></div>
        <div class="dropdown text-right">
            <a id="dropdownPosition" class="btn dropdown-toggle" href="#" aria-haspopup="true" aria-expanded="false"
               data-toggle="dropdown">
                <img class="avatar rounded-circle" src="/images/5f5e35ac45359.jpg" alt="Image Description">
                <i class="nova-angle-down icon-text icon-text-xs align-middle ml-3"></i>
            </a>

            <div class="dropdown-menu" aria-labelledby="dropdownPosition" style="width: inherit">
                <a class="dropdown-item disabled" href="#">{{Auth::user()->name}}</a>
                <div class="dropdown-divider"></div>
                <a class="text-danger nav-link px-3 mr-3"
                   href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
                    退出登陆
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
    @endif
    <ul class="nav nav-tabs nav-primary px-4 d-xl-flex">
        @if(!Auth::guest())
            <li class="nav-item"><a class="a-text-body nav-link px-3 py-075 mr-3 "
                                    href="/">Love</a></li>
            <li class="nav-item"><a class="a-text-body nav-link px-3 py-075 mr-3 "
                                    href="/photos">点滴记忆</a></li>
            <li class="nav-item"><a class="a-text-body nav-link px-3 py-075 mr-3 "
                                    href="{{route('videos.index')}}">视频</a></li>
            <li class="nav-item"><a class="a-text-body nav-link px-3 py-075 mr-3 " href="/resources">资源上传</a>
            </li>
        @endif
        @if(!Auth::guest() and Auth::user()->hasAnyRole('超级管理员'))
            <li class="nav-item"><a class="a-text-body nav-link px-3 py-075 mr-3 "
                                    href="/users">用户</a></li>
            <li class="nav-item"><a class="a-text-body nav-link px-3 py-075 mr-3 "
                                    href="/permissions">权限</a></li>
            <li class="nav-item"><a class="a-text-body nav-link px-3 py-075 mr-3 " href="/roles">角色</a>
            </li>
        @endif
        @if (Auth::guest())
            <li class="nav-item"><a class="a-text-body nav-link px-3 py-075 mr-3 "
                                    href="{{ route('login') }}">登陆</a></li>
            <li class="nav-item"><a class="a-text-body nav-link px-3 py-075 mr-3 "
                                    href="{{ route('register') }}">注册</a></li>
        @endif
    </ul>
</div>

<body>
@show
@if(Session::has('flash_message'))
    <div class="container">
        <div class="alert alert-success"><em> {!! session('flash_message') !!}</em>
        </div>
    </div>
@endif
@yield('content')
@yield('footer')
</body>
{{--<script src="{{asset('js/app.js')}}"></script>--}}

<script src="{{asset('nova/vendor/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('nova/vendor/jquery-migrate/dist/jquery-migrate.min.js')}}"></script>
<script src="{{asset('nova/vendor/popper.js/dist/umd/popper.min.js')}}"></script>
<script src="{{asset('nova/vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>

<script src="{{asset('layer/layer.js')}}"></script>
<!-- JS Nova -->
<script src="{{asset('nova/js/hs.core.js')}}"></script>
<script src="{{asset('nova/js/theme-custom.js')}}"></script>
<script src="{{asset('nova/js/components/hs.unfold.js')}}"></script>
<script src="{{asset('nova/js/components/hs.select2.js')}}"></script>
<script src="{{asset('nova/js/components/hs.header-search.js')}}"></script>
<script>
    $(document).on('ready', function () {
        // initialization of unfold component
        $.HSCore.components.HSUnfold.init($('[data-unfold-target]'));
        $.HSCore.components.HSHeaderSearch.init('.js-header-search');
    });
</script>
@yield('script')