<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Larave社区</title>
</head>
<body>
   <p style="margin:1.7em 0;">
       <br>欢迎加入Laravel社区(<a href="#" style=" text-decoration:none; color:#000000;" target="_blank">laravel社区</a>)
       <br>请点击该链接认证您的邮箱：<a href="{{ url('verify/'.$confirm_code) }}" style="color:#1F8919; text-decoration:none; text-decoration:none;" target="_blank">{{ url('verify/'.$confirm_code) }}</a>
       <br><span style="color:#999999;">(如果以上链接无法点击, 请将上面的地址复制到你的浏览器(如IE)的地址栏进入)</span>
   </p>
</body>
</html>