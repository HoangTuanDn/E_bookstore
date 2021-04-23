<div class="comments_area">
    <h3 class="comment__title">1 {{__('comments')}}</h3>
    <ul class="comment__list">
        <li>
            <div class="wn__comment">
                <div class="thumb">
                    <img src="{{asset('fontend/images/blog/comment/1.jpeg')}}" alt="comment images">
                </div>
                <div class="content">
                    <div class="comnt__author d-block d-sm-flex">
                        <span><a href="#">admin</a> Post author</span>
                        <span>October 6, 2014 at 9:26 am</span>
                        <div class="reply__btn">
                            <a href="#">{{__('reply')}}</a>
                        </div>
                    </div>
                    <p>Sed interdum at justo in efficitur. Vivamus gravida volutpat sodales. Fusce ornare sit</p>
                </div>
            </div>
        </li>
        <li class="comment_reply">
            <div class="wn__comment">
                <div class="thumb">
                    <img src="{{asset('fontend/images/blog/comment/1.jpeg')}}" alt="comment images">
                </div>
                <div class="content">
                    <div class="comnt__author d-block d-sm-flex">
                        <span><a href="#">admin</a> Post author</span>
                        <span>October 6, 2014 at 9:26 am</span>
                        <div class="reply__btn">
                            <a href="#">{{__('reply')}}</a>
                        </div>
                    </div>
                    <p>Sed interdum at justo in efficitur. Vivamus gravida volutpat sodales. Fusce ornare sit</p>
                </div>
            </div>
        </li>
    </ul>
</div>
<div class="comment_respond">
    <h3 class="reply_title">{{__('leave_a_reply')}} <small><a href="#">{{__('text_cancel')}}</a></small></h3>
    <form class="comment__form" action="#">
        <p>{{__('comment_respond_detail')}}</p>
        <div class="input__box">
            <textarea name="comment" placeholder="{{__('your_comment_here')}}"></textarea>
        </div>
        <div class="input__wrapper clearfix">
            <div class="input__box name one--third">
                <input type="text" placeholder="name">
            </div>
            <div class="input__box email one--third">
                <input type="email" placeholder="email">
            </div>
            <div class="input__box website one--third">
                <input type="text" placeholder="website">
            </div>
        </div>
        <div class="submite__btn">
            <a href="#">{{__('post_comment')}}</a>
        </div>
    </form>
</div>