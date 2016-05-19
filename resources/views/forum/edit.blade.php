@extends('app')
@section('content')
    @include('editor::head')
    <div class="container">
        <div class="row">
            <div class="create col-md-12">
                {!! Form::model($discussion, ['url'=>'/discuss/'.$discussion->id,'method'=>'PATCH']) !!}
                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    {!! Form::text('title', null, ['class' => 'form-control','placeholder'=>'讨论标题']) !!}
                    @if ($errors->has('title'))
                        <span class="help-block">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    {!! Form::select('tag_list[]', $tags, null, ['class' => 'form-control','multiple'=>'multiple','id'=>'tag_list']) !!}
                </div>
                <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                    <div class="editor">
                        {!! Form::textarea('body', null, ['class' => 'form-control','id'=>'myEditor']) !!}
                        @if ($errors->has('body'))
                            <span class="help-block">
                                <strong>{{ $errors->first('body') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::submit('更新帖子',['class'=>'btn btn-primary form-control']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@stop