@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 information">
                {!! Form::model($user,['url'=>'user/account']) !!}
                    <div class="form-group">
                        {!! Form::label('name', '用户名:', ['class'=>'col-sm-3 control-label']) !!}
                        <div class="col-sm-9 form-horizontal">
                            {!! Form::text('name', null, ['class' => 'form-control','readonly'=> 'readonly']) !!}
                            <code>用户名唯一,注册之后不能修改(如真的需要修改,请联系Axhello)</code>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('nickname', '用户昵称:', ['class'=>'col-sm-3 control-label']) !!}
                        <div class="col-sm-9 form-horizontal">
                            {!! Form::text('nickname', null, ['class' => 'form-control']) !!}
                            <code>昵称用于显示,支持中文,英文,数字</code>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('weibo') ? ' has-error' : '' }}">
                        {!! Form::label('weibo', '微博:', ['class'=>'col-sm-3 control-label']) !!}
                        <div class="col-sm-9 form-horizontal">
                            {!! Form::text('weibo', null, ['class' => 'form-control']) !!}
                            @if ($errors->has('weibo'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('weibo') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('github') ? ' has-error' : '' }}">
                        {!! Form::label('github', 'Github:', ['class'=>'col-sm-3 control-label']) !!}
                        <div class="col-sm-9 form-horizontal">
                            {!! Form::text('github', null, ['class' => 'form-control']) !!}
                            @if ($errors->has('github'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('github') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('city', '现居城市:', ['class'=>'col-sm-3 control-label']) !!}
                        <div class="col-sm-9 form-horizontal">
                            {!! Form::select('city', ['城市按字母排序'=>$cities], null, ['class' => 'js-states form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('blog') ? ' has-error' : '' }}">
                        {!! Form::label('blog', '个人网站:', ['class'=>'col-sm-3 control-label']) !!}
                        <div class="col-sm-9 form-horizontal">
                            {!! Form::text('blog', null, ['class' => 'form-control']) !!}
                            @if ($errors->has('blog'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('blog') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('desc', '自我介绍:', ['class'=>'col-sm-3 control-label']) !!}
                        <div class="col-sm-9 form-horizontal">
                            {!! Form::textarea('desc', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-sm-9 col-md-offset-3 form-horizontal">
                        {!! Form::submit('更新资料',['class'=>'btn btn-block btn-primary form-control']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="col-md-3 information">
                <div class="text-center">
                    <div id="validation-errors"></div>
                    <img src="{{Auth::user()->avatar}}" width="120" class="img-circle" id="user-avatar" alt="">
                    {!! Form::open(['url'=>'/user/avatar','files'=>true,'id'=>'avatar']) !!}
                    <div class="text-center">
                        <button type="button" class="btn btn-success avatar-button" id="upload-avatar">上传新的头像</button>
                        {!! Form::file('avatar',['class'=>'avatar','id'=>'image']) !!}
                    </div>
                    {!! Form::close() !!}
                    <div class="span5">
                        <div id="output" style="display:none">
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            {!! Form::open( [ 'url' => ['/crop/api'], 'method' => 'POST', 'onsubmit'=>'return checkCoords();','files' => true ] ) !!}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="exampleModalLabel">裁剪头像</h4>
                            </div>
                            <div class="modal-body">
                                <div class="content">
                                    <div class="crop-image-wrapper">
                                        <img src="{{ Auth::user()->avatar }}" class="ui centered image" id="cropbox">
                                        <input type="hidden" id="photo" name="photo"/>
                                        <input type="hidden" id="x" name="x"/>
                                        <input type="hidden" id="y" name="y"/>
                                        <input type="hidden" id="w" name="w"/>
                                        <input type="hidden" id="h" name="h"/>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                <button type="submit" class="btn btn-primary">裁剪头像</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/crop.js"></script>
@stop
