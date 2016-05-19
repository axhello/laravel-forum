@extends('app')

@section('content')
    <div class="jumbotron">
        <div class="container">
            <div class="jumbo">
                <h2>欢迎来到laravel社区
                    <a class="btn btn-danger btn-lg pull-right" href="/user/account" role="button">编辑资料</a>
                </h2>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div id="panel" class="panel panel-default panel-change">
                    <div class="panel-heading">修改密码</div>
                    <div class="panel-body">
                        <div class="password-change">
                            <form class="form-horizontal" role="form" method="POST"
                                  action="{{ url('/password/change') }}">
                                {!! csrf_field() !!}
                                <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}{{ Session::has('old_pass_error') ? ' has-error' : '' }}">
                                    <input :type="[isA ? 'password' : 'text']" class="form-control" name="old_password"
                                           value="{{ old('password') }}" placeholder="原密码">
                                    <i @click="toggleIconA" class="fa fa-lg" :class="[ hideA ? 'fa-eye-slash' : 'fa-eye' ]"></i>
                                    @if ($errors->has('old_password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('old_password') }}</strong>
                                        </span>
                                    @endif
                                    @if(Session::has('old_pass_error'))
                                        <span class="help-block">
                                             <strong >{{ Session::get('old_pass_error') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <input :type="[isB ? 'password' : 'text']" class="form-control" name="password"
                                           value="{{ old('password') }}" placeholder="新密码">
                                    <i @click="toggleIconB" class="fa fa-lg" :class="[ hideB ? 'fa-eye-slash' : 'fa-eye' ]"></i>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <input :type="[isC ? 'password' : 'text']" class="form-control" name="password_confirmation"
                                           value="{{ old('password') }}" placeholder="确认密码">
                                    <i @click="toggleIconC" class="fa fa-lg" :class="[ hideC ? 'fa-eye-slash' : 'fa-eye' ]"></i>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-block btn-primary">
                                        <i class="fa fa-btn fa-envelope"></i> 更改密码
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        new Vue({
            el: '#panel',
            data:{
                isA:true,
                hideA:false,

                isB:true,
                hideB:false,

                isC:true,
                hideC:false
            },
            methods:{
                toggleIconA:function(){
                    this.isA =! this.isA;
                    this.hideA =! this.hideA;
                },
                toggleIconB:function(){
                    this.isB =! this.isB;
                    this.hideB =! this.hideB;
                },
                toggleIconC:function(){
                    this.isC =! this.isC;
                    this.hideC =! this.hideC;
                }
            }
        })
    </script>
@endsection
