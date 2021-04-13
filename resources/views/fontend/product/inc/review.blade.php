<h1>{{__('customer_reviews')}}</h1>
@if($customerReviews)
    @foreach($customerReviews as $review)
        <h2>{{$review->pivot->nickname}}</h2>
        <div class="review__ratings__type d-flex justify-content-between">
            <div class="review-ratings">
                <div class="rating-summary d-flex">
                    <span>{{__('quality')}}</span>
                    <ul class="rating d-flex">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->pivot->quality_rate)
                                <li><i class="zmdi zmdi-star"></i></li>
                            @else
                                <li class="off"><i class="zmdi zmdi-star"></i></li>
                            @endif
                        @endfor
                    </ul>
                </div>

                <div class="rating-summary d-flex">
                    <span>{{__('price')}}</span>
                    <ul class="rating d-flex">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->pivot->price_rate)
                                <li><i class="zmdi zmdi-star"></i></li>
                            @else
                                <li class="off"><i class="zmdi zmdi-star"></i></li>
                            @endif
                        @endfor
                    </ul>
                </div>
                @if($review->pivot->content)
                    <div class="rating-summary d-flex review-detail">
                        <span>{{__('details') . ':'}}</span>
                        <ul class="rating d-flex detail-content">
                            <li>{{$review->pivot->content}}</li>
                        </ul>
                    </div>
                @endif
            </div>
            <div class="review-content">
                <p>{{__('review_by', ['name' => $review->pivot->nickname])}}</p>
                <p>{{__('posted_on', ['date'=> date('d-m-Y', strtotime($review->pivot->created_at))])}}</p>
            </div>
        </div>
    @endforeach
@else
    <h2>{{__('no_review')}}</h2>
@endif
