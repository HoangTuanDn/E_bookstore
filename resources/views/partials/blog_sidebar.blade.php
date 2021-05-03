
<div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
    <div class="wn__sidebar">
        <!-- Start Single Widget -->
        <aside class="widget search_widget">
            <h3 class="widget-title">{{__('search')}}</h3>
            <form action="#">
                <div class="form-input">
                    <input id="aa-search-input-blog" class="aa-input-search-blog"  type="search" placeholder="{{__('error_not_found_search')}}">
                    <button><i class="fa fa-search"></i></button>
                </div>
            </form>
        </aside>
        <!-- End Single Widget -->
        <!-- Start Single Widget -->
        <aside class="widget recent_widget">
            <h3 class="widget-title">{{__('recent')}}</h3>
            <div class="recent-posts">
                <ul>
                    @foreach($recentBlogs as $blog)
                        <li>
                            <div class="post-wrapper d-flex">
                                <div class="thumb">
                                    <a href="{{route('home.blog.detail', ['language'=> app()->getLocale(), 'slug' => $blog->slug])}}"><img src="{{asset($blog->featured_img)}}" alt="blog images"></a>
                                </div>
                                <div class="content">
                                    <h4><a href="{{route('home.blog.detail', ['language'=> app()->getLocale(), 'slug' => $blog->slug])}}">{{$blog->name}}</a></h4>

                                    @if(app()->getLocale() === 'vn')
                                        <p>	{{date('d-m-Y', strtotime($blog->created_at))}}</p>
                                    @else
                                        <p>	{{date('M d, Y', strtotime($blog->created_at))}}</p>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>
        <!-- End Single Widget -->
        <!-- Start Single Widget -->
        <aside class="widget comment_widget">
            <h3 class="widget-title">{{__('comments')}}</h3>
            <ul>
                @foreach($comments as $comment)
                    <li>
                        <div class="post-wrapper">
                            <div class="thumb">
                                <img   src="{{asset('fontend/images/blog/comment/1.jpeg')}}" alt="Comment images">
                            </div>
                            <div class="content">
                                <p>{{__('customer_says', ['name' => $comment->customer->name]) . ' :'}}</p>
                                <a href="#">{{$comment->comment}}</a>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </aside>
        <!-- End Single Widget -->
        <!-- Start Single Widget -->
        <aside class="widget category_widget">
            <h3 class="widget-title">{{__('categories_lc')}}</h3>
            <ul>
                @foreach($categories as $category)
                    <li><a data-action="filter-category" href="{{route('home.blog', ['language'=>app()->getLocale(),'category'=> $category->slug])}}">{{$category->name}}</a></li>
                @endforeach
            </ul>
        </aside>
        <!-- End Single Widget -->
        <!-- Start Single Widget -->
        <aside class="widget archives_widget">
            <h3 class="widget-title">{{__('archives')}}</h3>
            <ul>
                @foreach($archives as $archive)
                @endforeach
                @if(app()->getLocale() === 'vn')
                    <li><a data-action="filter-archives" href="{{route('home.blog', ['language'=> app()->getLocale(), 'month'=>date('n', strtotime($archive->created_at)), 'year' => date('Y', strtotime($archive->created_at))])}}">{{'Tháng '.date('n, Y', strtotime($archive->created_at))}}</a></li>
                @else
                    <li><a data-action="filter-archives" href="{{route('home.blog', ['language'=> app()->getLocale(), 'month'=>date('n', strtotime($archive->created_at)), 'year' => date('Y', strtotime($archive->created_at))])}}">{{date('F, Y', strtotime($archive->created_at))}}</a></li>
                @endif
            </ul>
        </aside>
        <!-- End Single Widget -->
    </div>
</div>