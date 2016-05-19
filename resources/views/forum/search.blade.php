@extends('app')
@section('content')
    <header class="jumbotron">
        <div class="container">
            <div class="col-xs-12">
                {!! Form::open(['url' => '/search','method'=>'GET','class'=> 'form-search']) !!}
                <div class="form-group">
                    <input type="text" class="form-control search" placeholder="搜索你想要的东西..." name="query">
                    <i class="fa fa-search"></i>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </header>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="list-group">
                    @if(count($results) > 0)
                        @foreach($results as $discussion)
                            <div class="list">
                                <div class="media">
                                    <div class="media-left">
                                        <a href="#">
                                            <img class="media-object img-circle" alt="64x64" src="{{ $discussion->user->avatar }}">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="media-heading"><a href="discuss/{{ $discussion->id }}">{{ $discussion->title }}</a>
                                            <div class="media-conversation-meta pull-right">
                                            <span class="media-conversation-replies">
                                            <a href="discuss/{{ $discussion->id }}/#Comment-1">{{ count($discussion->comments) }}</a>
                                            回复
                                            </span>
                                            </div>
                                        </h4>
                                        <a class="author" href="#">{{ $discussion->user->name }}</a>
                                        <p class="meta">更新于 {{ $discussion->updatedat() }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h3 class="empty">没有找到你想要的...</h3>
                    @endif
                </ul>
                {!! $results->appends(\Request::only('query'))->links() !!}
            </div>
        </div>
    </div>
@stop