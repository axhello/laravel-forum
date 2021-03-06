@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default panel-register">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/user/register') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">用户名:</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">邮箱:</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">密码:</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">确认密码:</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">验证码:</label>

                            <div id="captcha" class="col-md-6"></div>
                            <script src="http://static.geetest.com/static/tools/gt.js"></script>
                            <script>
                                var handler = function (captchaObj) {
                                    // 将验证码加到id为captcha的元素里
                                    captchaObj.appendTo("#captcha");
                                };
                                $.ajax({
                                    // 获取id，challenge，success（是否启用failback）
                                    url: "/captcha?rand="+Math.round(Math.random()*100),
                                    type: "get",
                                    dataType: "json", // 使用jsonp格式
                                    success: function (data) {
                                        // 使用initGeetest接口
                                        // 参数1：配置参数，与创建Geetest实例时接受的参数一致
                                        // 参数2：回调，回调的第一个参数验证码对象，之后可以使用它做appendTo之类的事件
                                        initGeetest({
                                            gt: data.gt,
                                            challenge: data.challenge,
                                            product: "float", // 产品形式
                                            offline: !data.success
                                        }, handler);
                                    }
                                });
                            </script>
                            @if ($errors->has('captcha'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('captcha') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>立即注册
                                </button>
                                <a href="/auth/github" class="btn btn-success">Github登录</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
