@extends('layouts.master')

@section('js')
    <script src="{{asset('fontend/common/ship.js')}}"></script>
@endsection

@section('content')
<!-- Start Bradcaump area -->
<div class="ht__bradcaump__area bg-image--4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="bradcaump__inner text-center">
                    <h2 class="bradcaump-title">Checkout</h2>
                    <nav class="bradcaump-content">
                        <a class="breadcrumb_item" href="index.html">Home</a>
                        <span class="brd-separetor">/</span>
                        <span class="breadcrumb_item active">Checkout</span>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Bradcaump area -->
<!-- Start Checkout Area -->
<section class="wn__checkout__area section-padding--lg bg__white">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="wn_checkout_wrap">

                    @if(auth()->guard('customer')->guest())
                        <div class="checkout_info">
                            <span>{{__('required_login')}}</span>
                            <a class="showlogin" href="#">{{__('login_titile')}}</a>
                        </div>
                        <div class="checkout_login">
                            <form class="wn__checkout__form" action="{{route('account.login', ['language' => app()->getLocale()])}}">
                                <p>{{__('checkout_title')}}</p>

                                <div class="input__box">
                                    <label>{{__('Username_email')}} <span>*</span></label>
                                    <input name="username_or_email" type="text">
                                </div>

                                <div class="input__box">
                                    <label>{{__('password')}} <span>*</span></label>
                                    <input name="password" type="password">
                                </div>
                                <div class="form__btn">
                                    <button data-action="login-checkout">{{__('login')}}</button>
                                    <label class="label-for-checkbox">
                                        <input id="rememberme" name="remember_me" value="forever" type="checkbox">
                                        <span>{{__('remember_me')}}</span>
                                    </label>
                                    <a href="#">{{(__('lost_your_password'))}}</a>
                                </div>
                            </form>
                        </div>
                    @endif

                    <div class="checkout_info">
                        <span>{{__('coupon_title')}} </span>
                        <a class="showcoupon" href="#">{{__('coupon_description')}}</a>
                    </div>
                    <div class="checkout_coupon">
                        <form action="{{route('home.checkout', ['language' => app()->getLocale()])}}">
                            <div class="form__coupon">
                                <input type="text" name="coupon_code" value="{{$order['coupon_code'] ?? ''}}" placeholder="{{__('coupon_code')}}">
                                <button data-action="apply-coupon">{{__('apply_coupon')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="customer_details">
                    <h3>{{__('billing_details')}}</h3>
                    <div class="customar__field" data-action="store-data" data-url="{{route('home.checkout', ['language' => app()->getLocale()])}}">
                        <div class="margin_between">
                            <div class="input_box space_between" style="width: 100%">
                                <label>{{__('full_name')}} <span>*</span></label>
                                <input name="full_name" required type="text">
                            </div>
                        </div>
                        <div class="input_box">
                            <label>{{__('province')}}<span>*</span></label>
                            <select required id="province" name="province_id" data-type="province" data-action="select-address" class="select__option">
                                <option>{{__('select_province')}}</option>
                                @foreach($provinces as $province)
                                    <option value="{{$province->id}}">{{$province->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input_box">
                            <label>{{__('district')}}<span>*</span></label>
                            <select required id="district" name="district_id" data-type="district" data-action="select-address" class="select__option">
                                <option value="">{{__('select_district')}}</option>
                            </select>
                        </div>

                        <div class="input_box">
                            <label>{{__('ward')}}<span>*</span></label>
                            <select required id="ward" name="ward_id" data-type="ward" data-action="select-address" class="select__option">
                                <option value="">{{__('select_ward')}}</option>
                            </select>
                        </div>
                        <div class="input_box">
                            <label>{{__('address')}} <span>*</span></label>
                            <input required name="address" type="text" placeholder="{{__('placeholder_address')}}">
                        </div>

                        <div class="margin_between">
                            <div class="input_box space_between">
                                <label>{{__('phone')}} <span>*</span></label>
                                <input name="phone" required type="text">
                            </div>

                            <div class="input_box space_between">
                                <label>{{__('email')}} <span>*</span></label>
                                <input name="email" required type="email">
                            </div>
                        </div>
                    </div>
                    <div class="order__form">
                        <form action="">
                            <div class="form__btn">
                                <button data-url="{{isset($slug) ? route('home.order', ['language' => app()->getLocale(), 'slug' => $slug]) : route('home.order', ['language' => app()->getLocale()])}}" data-action="apply-order">{{__('apply_order')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12 md-mt-40 sm-mt-40">
                <div class="wn__order__box">{!! $inc_cart !!}</div>
                <div id="accordion" class="checkout_accordion mt--30" role="tablist">
                    <div class="payment">
                        <div class="che__header" role="tab" id="headingOne">
                            <a class="checkout__title" data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                <span>{{__('direct_bank_transfer')}}</span>
                            </a>
                        </div>
                        <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="payment-body">{{__('direct_bank_transfer_title')}}</div>
                            <div class="payment-apply">
                                <label for="">{{__('select_payment')}}</label>
                                <input id="direct_bank_transfer" name="payment" data-index="0" value="1"  type="radio">
                            </div>
                        </div>
                    </div>
                   {{-- <div class="payment">
                        <div class="che__header" role="tab" id="headingTwo">
                            <a class="collapsed checkout__title" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <span>Cheque Payment</span>
                            </a>
                        </div>
                        <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="payment-body">Please send your cheque to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</div>
                        </div>
                    </div>--}}
                    <div class="payment">
                        <div class="che__header" role="tab" id="headingThree">
                            <a class="collapsed checkout__title" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <span>{{__('cash_on_delivery')}}</span>
                            </a>
                        </div>
                        <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="payment-body">{{__('cash_on_delivery_title')}}</div>
                            <div class="payment-apply">
                                <label for="">{{__('select_payment')}}</label>
                                <input id="direct_bank_transfer" name="payment" data-index="0" value="2"  type="radio">
                            </div>
                        </div>
                    </div>
                    <div class="payment">
                        <div class="che__header" role="tab" id="headingFour">
                            <a class="collapsed checkout__title" data-toggle="collapse" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                <span>{{__('paypal')}} <img src="{{asset('fontend/images/icons/payment.png')}}" alt="payment images"> </span>
                            </a>
                        </div>
                        <div id="collapseFour" class="collapse" role="tabpanel" aria-labelledby="headingFour" data-parent="#accordion">
                            <div class="payment-body">{{__('paypal_title')}}</div>
                            <div class="payment-apply">
                                {{--<label for="">{{__('select_payment')}}</label>
                                <input id="direct_bank_transfer" name="payment" data-index="0" value="3"  type="radio">--}}
                                <div class="paypal_order__form">
                                    <form action="">
                                        <div class="form__btn_paypal">
                                            <button data-url="{{isset($slug) ? route('home.payment', ['language' => app()->getLocale(), 'slug' => $slug]) : route('home.payment', ['language' => app()->getLocale()])}}" data-action="payment-checkout"><img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-small.png" alt="Check out with PayPal" /></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- End Checkout Area -->
@endsection