<title>肖家军</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdn.staticfile.org/foundation/5.5.3/css/foundation.min.css">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link href="{{ asset('css/styles.css') }}" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script><script src="https://cdn.staticfile.org/foundation/5.5.3/js/vendor/modernizr.js"></script>
<nav class="top-bar" data-topbar>
    <ul class="title-area">
        <li class="name">
            <!-- 如果你不需要标题或图标可以删掉它 -->
            <h1><a href="/">肖家军</a></h1>
        </li>
        <!-- 小屏幕上折叠按钮: 去掉 .menu-icon 类，可以去除图标。
        如果需要只显示图片，可以删除 "Menu" 文本 -->
        <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
    </ul>

    <section class="top-bar-section">
        <ul class="left">
            <li><a href="/student/lab">学生主页</a></li>
            <li><a href="/photos"> 照片分享</a></li>
            @if(!Auth::guest())
                <li><a href="/resources">资源上传</a></li>
                <li><a href="/papers">论文列表</a></li>
                <li><a href="/labbooks">书籍管理</a></li>
                <li><a href="/tools">仪器借阅</a></li>
            @endif

            @if(!Auth::guest() and Auth::user()->hasAnyRole('超级管理员'))
            <li><a href="users">用户</a></li>
                <li><a href="permissions">权限</a></li>
                <li><a href="roles">角色</a></li>
                <li><a href="informations">学生信息</a></li>

            @endif



        </ul>
        <ul class="right">
            <!-- Authentication Links -->
            @if (Auth::guest())
                <li><a href="{{ route('login') }}">登陆</a></li>
                <li><a href="{{ route('register') }}">注册</a></li>
            @else

                <li ><a href="/student/show/{{Auth::user()->email}}"> {{ Auth::user()->name }}</a>
                </li>
                <li>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    退出登陆
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
                </li>
            @endif

        </ul>
    </section>
</nav>
<body style="text-align:center;">
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
<!-- 初始化 Foundation JS -->
<script>
    $(document).ready(function() {
        $(document).foundation();
    })
</script>