@extends('layouts.master')

@section('content')
    <!-- Start Bradcaump area -->
    <div class="ht__bradcaump__area bg-image--4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">Blog Page</h2>
                        <nav class="bradcaump-content">
                            <a class="breadcrumb_item" href="index.html">Home</a>
                            <span class="brd-separetor">/</span>
                            <span class="breadcrumb_item active">Blog</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
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