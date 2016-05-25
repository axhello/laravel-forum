@extends('app')
@section('content')
    <div class="jumbotron">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <div class="profile-view media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-avatar" src="{{ $user->avatar }}">
                            </a>
                        </div>

                    </div>
                </div>
                <div class="col-md-5 profile">
                    <div class="media-body">
                        <h4 class="media-heading">{{ $user->name }}</h4>
                    </div>
                    <ul class="info-list">
                        <li>现居城市：{{ $user->city }}</li>
                        <li>个人网站：{{ $user->blog }}</li>
                    </ul>
                </div>
                @if(Auth::check() && $user->id == Auth::id())
                <div class="col-md-2 pull-right">
                    <div class="edit-info">
                        <a class="btn btn-danger btn-lg" href="/user/account" role="button">编辑资料</a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <footer class="banner_footer">
        <div class="container">
            <ul class="banner-profile">
                @if($user->weibo)
                    <li>
                        <a href="{{ $user->weibo }}" class="profile_weibo" target="_blank"><i class="fa fa-weibo fa-lg"></i>{{ $user->name }}</a>
                    </li>
                @endif
                @if($user->github)
                    <li>
                        <a href="{{ $user->github }}" class="profile_github" target="_blank"><i class="fa fa-github fa-lg"></i>{{ $user->name }}</a>
                    </li>
                @endif
                <li>
                    <div href="#" class="profile_join">
                        <i class="fa fa-calendar"></i>
                        {{ $user->created_at }} 加入 laravist
                    </div>
                </li>
            </ul>
        </div>
    </footer>
    <div class="container">
        <section class="section-timeline">
            <div class="timeline">
                <div class="content-wrapper">
                    @foreach($comments as $comment)
                        <div class="moment">
                            <div class="row event clearfix">
                                <div class="col-sm-1">
                                    <div class="status-icon status-3" data-toggle="tooltip" title="" data-placement="left" data-original-title="发表评论">
                                        <i class="icon ion-eye fa fa-flag oranges"></i>
                                    </div>
                                </div>
                                <div class="col-xs-10 col-xs-offset-2 col-sm-11 col-sm-offset-0">
                                    <div class="panel panel-message incident">
                                        <div class="panel-heading">
                                            <strong><a style="color: #333;" href="/discuss/{{ $comment->discussions->id }}#reply-{{ $comment->id }}">
                                                    {{ $comment->discussions->title }}
                                                </a></strong>
                                            <br>
                                            <small class="date">
                                                <a href="/discuss/{{ $comment->discussions->id }}#reply-{{ $comment->id }}" class="links">
                                                    <abbr class="timeago" data-toggle="tooltip" data-placement="right" title="" data-timeago="2016-03-25T22:52:19+08:00" data-original-title="Friday 25 March 2016">
                                                        评论发表于 {{ $comment->updatedat() }}
                                                    </abbr></a>
                                            </small>
                                        </div>
                                        <div class="panel-body">
                                            {!! str_limit(strip_tags($comment->body),100) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {!! $comments->render() !!}
                </div>
            </div>
        </section>
    </div>
@stop