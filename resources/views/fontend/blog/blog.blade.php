@extends('layouts.master')

@section('content')
    <!-- Start Bradcaump area -->
    <div class="ht__bradcaump__area bg-image--4">
        @include('fontend.breadcumb',['pageNameLC' => __('blog')])
    </div>
    <!-- End Bradcaump area -->
    <!-- Start Blog Area -->
    <div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
        <div class="container">
            <div class="row blog-wrapper">
                <div class="col-lg-9 col-12 blog-content-detail">
                    {!! $inc_list !!}
                </div>
                @include('partials.blog_sidebar')
            </div>
        </div>
    </div>
    <!-- End Blog Area -->
@endsection

@section('js')
    <script src="{{asset('fontend/common/blog.js')}}"></script>
@endsection