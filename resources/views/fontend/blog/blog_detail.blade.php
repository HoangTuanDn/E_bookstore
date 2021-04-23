@extends('layouts.master')

@section('js')
{{--    <script src="{{asset('fontend/common/single.js')}}"></script>
    <script src="{{asset('fontend/common/cart.js')}}"></script>--}}
@endsection

@section('content')
    <div class="ht__bradcaump__area bg-image--6">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">Blog Details</h2>
                        <nav class="bradcaump-content">
                            <a class="breadcrumb_item" href="index.html">Home</a>
                            <span class="brd-separetor">/</span>
                            <span class="breadcrumb_item active">Blog-Details</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-blog-details section-padding--lg bg--white">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-12">
                    <div class="blog-details content">
                        <article class="blog-post-details">
                            <div class="post-thumbnail">
                                <img src="{{asset($blog->featured_img)}}" alt="blog images">
                            </div>
                            <div class="post_wrapper">
                                <div class="post_header">
                                    <h2>{{$blog->name}}</h2>
                                    <div class="blog-date-categori">
                                        <ul>
                                            @if(app()->getLocale() === 'vn')
                                                <li>{{'Tháng '. date('n, d, Y', strtotime($blog->created_at))}}</li>
                                            @else
                                                <li>{{date('M d, Y', strtotime($blog->created_at))}}</li>
                                            @endif
                                            <li><a href="#" title="{{__('posts_by').' '. $blog->author->name}}" rel="author">{{$blog->author->name}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="post_content">
                                    {!! $blog->content !!}
                                </div>
                                <ul class="blog_meta">
                                    <li><a href="#">3 {{__('comments')}}</a></li>
                                    <li> / </li>
                                    <li>{{__('blog_category')}}:<span>{{$blog->category->name}}</span></li>
                                </ul>
                            </div>
                        </article>
                        @include('fontend.blog.inc.blog_comment')
                    </div>
                </div>

                @include('partials.blog_sidebar')
            </div>
        </div>
    </div>
@endsection
