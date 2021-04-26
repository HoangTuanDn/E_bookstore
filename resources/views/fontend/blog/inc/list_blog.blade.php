
<div class="blog-page">
    <div class="page__header">
        <h2>{{__('category_archives') .' : '. $categoryName}}</h2>
    </div>
    <!-- Start Single Post -->
    @foreach($blogs as $blog)
        <article class="blog__post d-flex flex-wrap">
            <div class="thumb">
                <a href="{{route('home.blog.detail',['language'=>app()->getLocale(), 'slug' => $blog['slug']])}}">
                    <img src="{{asset($blog['featured_img'])}}" alt="blog images">
                </a>
            </div>
            <div class="content">
                <h4><a href="{{route('home.blog.detail',['language'=>app()->getLocale(), 'slug' => $blog['slug']])}}">{{$blog['name']}}</a></h4>
                <ul class="post__meta">
                    <li>{{__('posts_by')}} : <a href="#">{{$blog['author']}}</a></li>
                    <li class="post_separator">/</li>
                    @if(app()->getLocale() === 'vn')
                        <li>{{$blog['created_at']['vn']}}</li>
                    @else
                        <li>{{$blog['created_at']['en']}}</li>
                    @endif
                </ul>
                {!! $blog['title'] !!}
                <div class="blog__btn">
                    <a href="{{route('home.blog.detail',['language'=>app()->getLocale(), 'slug' => $blog['slug']])}}">{{__('read_more')}}</a>
                </div>
            </div>
        </article>
@endforeach
<!-- End Single Post -->
</div>
{!! $pagination !!}