@extends('app')
@section('content')
    <div class="jumbotron">
        <div class="container">
            <div class="jumbo">
                <h2>欢迎来到laravel社区
                    <a class="btn btn-danger btn-lg pull-right" href="/discuss/create" role="button">
                        <i class="fa fa-paper-plane"></i>发布新帖子</a>
                </h2>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-9" role="main">
                <div class="List-responsive">
                    @foreach($favorites as $discussion)
                        <div class="list">
                            <div class="media">
                                <div class="media-left">
                                    <a href="/user/{{ $discussion->user->name }}">
                                        <img class="media-object img-circle" alt="64x64" src="{{ $discussion->user->avatar }}">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading"><a href="/discuss/{{ $discussion->id }}">{{ $discussion->title }}</a>
                                        <div class="media-conversation-meta pull-right">
                                            <span class="media-conversation-replies">
                                            <a href="/discuss/{{ $discussion->id }}/#Comment-1">{{ count($discussion->comments) }}</a>
                                            回复
                                            </span>
                                        </div>
                                    </h4>
                                    <a class="author" href="/user/{{ $discussion->user->name }}">{{ $discussion->user->name }}</a>
                                    <p class="meta">更新于 {{ $discussion->updatedat() }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {!! $favorites->render() !!}
                <hr>
            </div>
        </div>
    </div>
@stop