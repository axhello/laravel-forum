<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>laravel Forum</title>
    <meta id="token" name="token" value="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ elixir('css/all.css') }}">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/dropzone.css">
    <script src="/js/all.js"></script>
</head>
<body>
<nav class="navbar navbar-default nav-bg">
    <div class="container">
        <div class="navheader">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Laravel Forum</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        {!! Form::open(['url' => '/search','method'=>'GET','class'=> 'navbar-form']) !!}
                        <div class="input-textfield">
                            <input type="text" class="form-textfield" placeholder="要搜索的内容..." name="query">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </div>
                        {!! Form::close() !!}
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @if(Auth::check())
                        <li class="dropdown">
                            <a id="dlabel" type="button" class="dropdown-toggle" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dLabel">
                                <li><a href="/user/profile"> <i class="fa fa-user"></i> 个人资料</a></li>
                                <li><a href="/user/account"> <i class="fa fa-cog"></i> 账号设置</a></li>
                                <li><a href="/password/change"> <i class="fa fa-lock"></i> 更改密码</a></li>
                                <li><a href="/user/favorites"> <i class="fa fa-heart"></i> 收藏列表</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="/user/logout"> <i class="fa fa-sign-out"></i> 退出登录</a></li>
                            </ul>
                        </li>
                        <li class="avatar-img"><img src="{{ Auth::user()->avatar }}" class="img-circle" width="52" alt=""></li>
                    @else
                        <li class="login"><a id="loginButton" href="/user/login">登 录</a></li>
                        <li class="register"><a id="btn" href="/user/register">注 册</a></li>
                    @endif
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</nav>

@yield('content')

@include('alert')

@include('forum.footer')

<script>
    $("#tag_list").select2({
        placeholder: '选择一个标签',
        tags       : true
    })
</script>
</body>
</html>