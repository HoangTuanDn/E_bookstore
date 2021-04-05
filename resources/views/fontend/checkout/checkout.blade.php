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
                    <div class="checkout_info">
                        <span>{{__('required_login')}}</span>
                        <a class="showlogin" href="#">{{__('login_titile')}}</a>
                    </div>
                    <div class="checkout_login">
                        <form class="wn__checkout__form" action="#">
                            <p>{{__('checkout_title')}}</p>

                            <div class="input__box">
                                <label>{{__('Username_email')}} <span>*</span></label>
                                <input type="text">
                            </div>

                            <div class="input__box">
                                <label>{{__('passwrod')}} <span>*</span></label>
                                <input type="password">
                            </div>
                            <div class="form__btn">
                                <button>Login</button>
                                <label class="label-for-checkbox">
                                    <input id="rememberme" name="rememberme" value="forever" type="checkbox">
                                    <span>Remember me</span>
                                </label>
                                <a href="#">Lost your password?</a>
                            </div>
                        </form>
                    </div>
                    <div class="checkout_info">
                        <span>{{__('coupon_title')}} </span>
                        <a class="showcoupon" href="#">{{__('coupon_description')}}</a>
                    </div>
                    <div class="checkout_coupon">
                        <form action="{{route('home.checkout')}}">
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
                    <div class="customar__field" data-action="store-data" data-url="{{route('home.checkout')}}">
                        <div class="margin_between">
                            <div class="input_box space_between" style="width: 100%">
                                <label>{{__('full_name')}} <span>*</span></label>
                                <input required type="text">
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
                            <input required type="text" placeholder="{{__('placeholder_address')}}">
                        </div>

                        <div class="margin_between">
                            <div class="input_box space_between">
                                <label>{{__('phone')}} <span>*</span></label>
                                <input required type="text">
                            </div>

                            <div class="input_box space_between">
                                <label>{{__('email')}} <span>*</span></label>
                                <input required type="email">
                            </div>
                        </div>
                    </div>
                    <div class="create__account">
                        <div class="wn__accountbox">
                            <input class="input-checkbox" name="createaccount" value="1" type="checkbox">
                            <span>Create an account ?</span>
                        </div>
                        <div class="account__field">
                            <form action="#">
                                <label>Account password <span>*</span></label>
                                <input type="text" placeholder="password">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="customer_details mt--20">
                    <div class="differt__address">
                        <input name="ship_to_different_address" value="1" type="checkbox">
                        <span>Ship to a different address ?</span>
                    </div>
                    <div class="customar__field differt__form mt--40">
                        <div class="margin_between">
                            <div class="input_box space_between">
                                <label>First name <span>*</span></label>
                                <input type="text">
                            </div>
                            <div class="input_box space_between">
                                <label>last name <span>*</span></label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="input_box">
                            <label>Company name <span>*</span></label>
                            <input type="text">
                        </div>
                        <div class="input_box">
                            <label>Country<span>*</span></label>
                            <select class="select__option">
                                <option>Select a country…</option>
                                <option>Afghanistan</option>
                                <option>American Samoa</option>
                                <option>Anguilla</option>
                                <option>American Samoa</option>
                                <option>Antarctica</option>
                                <option>Antigua and Barbuda</option>
                            </select>
                        </div>
                        <div class="input_box">
                            <label>Address <span>*</span></label>
                            <input type="text" placeholder="Street address">
                        </div>
                        <div class="input_box">
                            <input type="text" placeholder="Apartment, suite, unit etc. (optional)">
                        </div>
                        <div class="input_box">
                            <label>District<span>*</span></label>
                            <select class="select__option">
                                <option>Select a country…</option>
                                <option>Afghanistan</option>
                                <option>American Samoa</option>
                                <option>Anguilla</option>
                                <option>American Samoa</option>
                                <option>Antarctica</option>
                                <option>Antigua and Barbuda</option>
                            </select>
                        </div>
                        <div class="input_box">
                            <label>Postcode / ZIP <span>*</span></label>
                            <input type="text">
                        </div>
                        <div class="margin_between">
                            <div class="input_box space_between">
                                <label>Phone <span>*</span></label>
                                <input type="text">
                            </div>
                            <div class="input_box space_between">
                                <label>Email address <span>*</span></label>
                                <input type="email">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12 md-mt-40 sm-mt-40">
                <div class="wn__order__box">{!! $inc_cart !!}</div>
                <div id="accordion" class="checkout_accordion mt--30" role="tablist">
                    <div class="payment">
                        <div class="che__header" role="tab" id="headingOne">
                            <a class="checkout__title" data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <span>Direct Bank Transfer</span>
                            </a>
                        </div>
                        <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="payment-body">Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</div>
                        </div>
                    </div>
                    <div class="payment">
                        <div class="che__header" role="tab" id="headingTwo">
                            <a class="collapsed checkout__title" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <span>Cheque Payment</span>
                            </a>
                        </div>
                        <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="payment-body">Please send your cheque to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</div>
                        </div>
                    </div>
                    <div class="payment">
                        <div class="che__header" role="tab" id="headingThree">
                            <a class="collapsed checkout__title" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <span>Cash on Delivery</span>
                            </a>
                        </div>
                        <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="payment-body">Pay with cash upon delivery.</div>
                        </div>
                    </div>
                    <div class="payment">
                        <div class="che__header" role="tab" id="headingFour">
                            <a class="collapsed checkout__title" data-toggle="collapse" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                <span>PayPal <img src="{{asset('fontend/images/icons/payment.png')}}" alt="payment images"> </span>
                            </a>
                        </div>
                        <div id="collapseFour" class="collapse" role="tabpanel" aria-labelledby="headingFour" data-parent="#accordion">
                            <div class="payment-body">Pay with cash upon delivery.</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- End Checkout Area -->
@endsection