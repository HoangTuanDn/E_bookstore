
@if($comments)
    <h3 class="comment__title">{{$blog->comments()->count() .' '. __('comments')}}</h3>
    @foreach($comments as $comment)
        <ul class="comment__list">
            <li>
                <div class="wn__comment">
                    <div class="thumb">
                        <img src="{{asset('fontend/images/blog/comment/1.jpeg')}}" alt="comment images">
                    </div>
                    <div class="content">
                        <div class="comnt__author d-block d-sm-flex">
                             @if($comment->customer->email === $comment->blog->author->email)
                                 <span><a href="#">{{$comment->customer->name}}</a> Post author</span>
                             @else
                                 <span><a href="#">{{$comment->customer->name}}</a></span>
                             @endif

                           {{-- <span><a href="#">{{$comment->customer->name}}</a></span>--}}

                            @if(app()->getLocale()  === 'vn')
                                <span>{{'Tháng ' . date('n, d, Y', strtotime($comment->created_at)) . __('at') . date('H:i', strtotime($comment->created_at))}}</span>
                            @else
                                <span>{{date('M d, Y', strtotime($comment->created_at)) . __('at') . date('H:i', strtotime($comment->created_at))}}</span>
                            @endif

                            <div class="reply__btn">
                                <a href="#" data-id="{{$comment->id}}" data-action="repy-comment">{{__('reply')}}</a>
                            </div>
                        </div>
                        <p>{{$comment->comment}}</p>
                    </div>
                </div>
            </li>
            <li>
                <div class="content_reply">
                    <div class="comment_respond d-block">
                        <form class="comment__form" action="{{route('home.blog.comment', ['language' => app()->getLocale()])}}">
                            <div class="input__box">
                                <textarea name="comment"></textarea>
                            </div>
                            <div class="submite__btn">
                                <a href="#" data-action="post-comment" data-id="{{$blog->id}}" data-parent="0">{{__('send')}}</a>
                            </div>
                        </form>
                    </div>

                </div>
            </li>
            @foreach($comment->replies as $reply)
                <li class="comment_reply">
                    <div class="wn__comment">
                        <div class="thumb">
                            <img src="{{asset('fontend/images/blog/comment/1.jpeg')}}" alt="comment images">
                        </div>
                        <div class="content">
                            <div class="comnt__author d-block d-sm-flex">
                                <span><a href="#">{{$reply->customer->name}}</a></span>

                                @if(app()->getLocale()  === 'vn')
                                    <span>{{'Tháng ' . date('n, d, Y', strtotime($reply->created_at)) . __('at') . date('H:i', strtotime($comment->created_at))}}</span>
                                @else
                                    <span>{{date('M d, Y', strtotime($reply->created_at)) . __('at') . date('H:i', strtotime($comment->created_at))}}</span>
                                @endif
                            </div>
                            <p>{{$reply->comment}}</p>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @endforeach
@endif
