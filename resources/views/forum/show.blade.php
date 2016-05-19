@extends('app')
@section('content')

    <div id="app">
        <div class="jumbotron">
            <div class="container">
                <div class="info">
                    <div class="media discuss_title animate">
                        <div class="media-left">
                            <a href="/user/{{ $discussion->user->name }}">
                                <img class="media-object img-circle bounceIn" alt="64x64" src="{{ $discussion->user->avatar }}">
                            </a>
                        </div>
                        <div class="media-body">
                            <h3 class="media-heading">{{ $discussion->title }}
                                @if(Auth::check() && Auth::user()->id == $discussion->user->id)
                                    <a class="btn btn-danger btn-lg pull-right"
                                       href="/discuss/{{ $discussion->id }}/edit" role="button">修改帖子</a>
                                @endif
                            </h3>
                            <h4>{{ $discussion->user->name }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="banner_footer">
            <div class="container">
                <div class="tags">
                    @foreach($discussion->tags as $tag)
                        <a href="/discuss/tags/{{ $tag->name }}" class="tag tag-sm  class not-mobile"><i class="fa fa-tag"></i> {{ $tag->name }}</a>
                    @endforeach
                </div>
            </div>
        </footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12 discuss" id="post">
                    <div>
                        <div id="question" class="Comment">
                            <div class="Media animate">
                                <div class="Media_avatar">
                                    <a href="/user/{{ $discussion->user->name }}">
                                        <img class="media-object img-circle bounceIn" alt="64x64" src="{{ $discussion->user->avatar }}">
                                    </a>
                                </div>
                                <div class="Media_body">
                                    <h5>
                                        <a href="/user/{{ $discussion->user->name }}">{{ $discussion->user->name }}</a>
                                        <span class="Comment_days-ago">
                                            - 发表于 {{ $discussion->updatedat() }}
                                        </span>
                                    </h5>
                                    <div class="content">
                                        {!! $html !!}
                                    </div>
                                </div>
                            </div>
                            <footer class="Comment_footer">
                                <div class="discussion_star">
                                    @if(Auth::check())
                                        <span @click="deFavorite" class="tag favorites liked {{ in_array($discussion->id,$favorites) ? 'done' : 'doned' }}">
                                        <i class="fa fa-check"></i> 已收藏
                                        </span>
                                        <span @click="onFavorite" class="tag favorites like {{ in_array($discussion->id,$favorites) ? 'doned' : 'done' }}">
                                        <i class="fa fa-star"></i> 收藏
                                        </span>
                                    @else
                                        <a href="/user/login">
                                        <span class="tag favorites like done">
                                            <i class="fa fa-star"></i> 收藏
                                        </span>
                                        </a>
                                    @endif
                                </div>
                                <div class="report-span pull-right">
                                    <i class="fa fa-meh-o fa-2x"></i>
                                </div>
                            </footer>
                        </div>
                        <div id="Reply_list">
                            @foreach($comments as $comment)
                                <div id="reply-{{ $comment->id }}" class="Comment">
                                    <div class="Media animate">
                                        <div class="Media_avatar">
                                            <a href="/user/{{ $comment->user->name }}">
                                                <img class  ="media-object img-circle bounceIn" alt="64x64"
                                                     src="{{ $comment->user->avatar }}">
                                            </a>
                                        </div>
                                        <div class="Media-body">
                                            <h5>
                                                <a href="/user/{{ $comment->user->name }}">{{ $comment->user->name }}</a>
                                        <span class="Comment_days-ago">
                                            - 发表于 {{ $comment->updatedat() }}
                                        </span>
                                            </h5>
                                            <div id="content">
                                                {!! $comment->body !!}
                                            </div>
                                        </div>
                                    </div>
                                    <footer class="Comment_footer clearfix">
                                        <div class="thumbs-like pull-left">
                                            <forum-post-like-button
                                                    comment-id="{{ $comment->id }}"
                                                    @if(Auth::check())
                                                    current-user="{{ \Auth::user()->name }}"
                                                    @else
                                                    current-user=""
                                                    @endif
                                                    user-liked="{{ implode(',', $comment->likes->lists('name')->toArray()) }}"
                                            >
                                            </forum-post-like-button>
                                       </div>
                                       <div class="report-span pull-right">
                                           <i class="fa fa-meh-o fa-2x"></i>
                                       </div>
                                   </footer>
                               </div>
                           @endforeach
                           @if(Auth::check())
                               <div id="reply" class="Comment" v-for="comment in comments">
                                   <div class="Media animate">
                                       <div class="Media_avatar">
                                           <a href="/user/@{{ comment.name }}">
                                               <img class="media-object img-circle bounceIn" alt="64x64" :src="comment.avatar">
                                           </a>
                                       </div>
                                       <div class="Media-body">
                                           <h5>
                                               <a href="/user/@{{ comment.name }}">@{{ comment.name }}</a>
                                               <span class="Comment_days-ago">
                                                    - 发表于 刚刚
                                               </span>
                                           </h5>
                                           <div class="content" v-html="comment.body"></div>
                                       </div>
                                   </div>
                                   <footer class="Comment_footer align-right">
                                       <div class="thumbs-like">
                                           <button class="likes-submit" type="submit">
                                               <i class="fa fa-lg fa-thumbs-o-up"></i>
                                           </button>
                                       </div>
                                       <div class="report-span pull-right">
                                           <i class="fa fa-meh-o fa-2x"></i>
                                       </div>
                                   </footer>
                               </div>
                           @endif
                       {!! $comments->render() !!}
                       </div>
                   </div>
                   <hr>
                   <div class="comments-form">
                       @if(Auth::check())
                           <div class="self-avatar">
                               <div class="media">
                                   <div class="media-left">
                                       <a href="#">
                                         <img class="media-object img-circle" alt="64x64" src="{{ Auth::user()->avatar }}" style="width: 64px; height: 64px;">
                                       </a>
                                   </div>
                               </div>
                           </div>
                           <form method="POST" action="{{ url('') }}" class="col-md-10" accept-charset="UTF-8" id="reply_form" @submit.prevent="onSubmitForm()">
                               {{ csrf_field() }}
                               <input name="discussion_id" type="hidden" value="{{ $discussion->id }}">
                               <input name="user_id" type="hidden" value="{{ Auth::user()->id }}">
                               <div class="form-group reply-form_textarea" :class="[isEmpty ? 'has-error' : '']">
                                   <textarea class="form-control" name="body" id="body" cols="50" rows="10" placeholder="支持Markdown语法" v-model="newMessage.body"></textarea>
                                   @if ($errors->has('body'))
                                       <span class="help-block">
                                           <strong>{{ $errors->first('body') }}</strong>
                                       </span>
                                   @endif
                               </div>
                               <div class="col-md-8">
                                   <div class="file-dropzone reply-form_images dz-clickable dz-started" id="dropzone">
                                       <p class="dz-message" id="uploaded-message" style="font-weight: bold;">评论图片拖到这里上传</p>
                                   </div>
                               </div>
                               <div class="col-md-offset-1">
                                   <div class="reply-form_submit">
                                       <input type="submit" class="btn btnBlack col-md-4" value="发表评论" style="font-weight: bold;">
                                   </div>
                               </div>
                           </form>

                       @else
                           <a href="/user/login" class="btn btn-block btn-success">登录并发表评论</a>
                       @endif
                   </div>
               </div>
           </div>
       </div>
   </div> {{--#app--}}
   @if(Auth::check())
       @include('forum.script.comments')
   @endif
    @include('forum.script.likes')
    <div id="preview-template" style="display: none;">
        <div class="dropzone-preview-pre">
            <div></div>
        </div>
    </div>
    <script src="/js/dropzone.js"></script>
    <script>
        Dropzone.autoDiscover = false;
        $(function() {
            var myDropzone = new Dropzone("#dropzone", {
                url: "/comment/image",
                maxFilesize: 2,
                clickable:true,
                previewsContainer:null,
                acceptedFiles:"image/*",
                previewTemplate:document.querySelector('#preview-template').innerHTML
            });
            myDropzone.on('success',function(file,response){
                var caretPosition = document.getElementById("body").selectionStart;
                var textArea = $("#body");
                var textAreaTxt = textArea.val();
                var insertText = response.url;
                textArea.val(textAreaTxt.substring(0, caretPosition) + '![图片描述]('+insertText+')');
                textArea.focus();
                $('#uploaded-message').addClass('success-message').text('图片上传成功,再次拖拽可以再次上传');
            });
        });
    </script>
@stop
