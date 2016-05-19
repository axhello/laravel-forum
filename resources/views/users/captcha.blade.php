<!DOCTYPE html>
<html>
<head>
    <title>Laravel Geetest</title>
    <script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
    <script src="http://static.geetest.com/static/js/geetest.5.3.6.js"></script>
</head>
<body>
<div class="container">
    <div class="content" id="container">
        <div class="title">Laravel 5</div>
        <form method="post" action="/user/login">
            {{ csrf_field() }}
            <div class="box">
                <label>邮箱：</label>
                <input type="text" name="email" value=""/>
            </div>
            <div class="box">
                <label>密码：</label>
                <input type="password" name="password" />
            </div>
            <div class="box" id="div_geetest_lib">
                <div id="captcha"></div>
                <script src="http://static.geetest.com/static/tools/gt.js"></script>
                <script>
                    var handler = function (captchaObj) {
                        // 将验证码加到id为captcha的元素里
                        captchaObj.appendTo("#captcha");
                    };
                    $.ajax({
                        // 获取id，challenge，success（是否启用failback）
                        url: "captcha?rand="+Math.round(Math.random()*100),
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
            </div>
            <div class="box">
                <button id="submit_button">提交</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>