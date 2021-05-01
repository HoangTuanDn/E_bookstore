@extends('layouts.master')

@section('content')
<!-- Start Bradcaump area -->
<div class="ht__bradcaump__area bg-image--3">
    @include('fontend.breadcumb',['pageNameLC' => __('shopping_cart')])
</div>
<!-- End Bradcaump area -->
<!-- cart-main-area start -->
<div class="cart-main-area section-padding--lg bg--white">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 ol-lg-12">
                <form action="#" class="cart-form">
                    {!! $inc_list !!}
                </form>
                <div class="cartbox__btn">
                    <ul class="cart__btn__list d-flex flex-wrap flex-md-nowrap flex-lg-nowrap justify-content-between">
                {{--        <li><a href="#">{{__('update_cart')}}</a></li>--}}
                        <li><a href="{{route('home.checkout', ['language' => app()->getLocale()])}}">{{__('check_out')}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 offset-lg-6">
                <div class="cartbox__total__area">
                    <div class="cart__total__amount">
                        <span>{{__('grand_total_cart')}}</span>
                        <span class="grand_total_cart">{{number_format($totalPrice, 0, ',', '.') . __('currency_unit')}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
    <script src="{{asset('fontend/common/cart.js')}}"></script>
@endsection