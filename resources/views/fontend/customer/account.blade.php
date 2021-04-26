@extends('layouts.master')

@section('js')
    <script src="{{asset('fontend/common/account.js')}}"></script>
@endsection

@section('content')
<!-- Start Bradcaump area -->
<div class="ht__bradcaump__area bg-image--6">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="bradcaump__inner text-center">
                    <h2 class="bradcaump-title">My Account</h2>
                    <nav class="bradcaump-content">
                        <a class="breadcrumb_item" href="index.html">Home</a>
                        <span class="brd-separetor">/</span>
                        <span class="breadcrumb_item active">My Account</span>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Bradcaump area -->
<!-- Start My Account Area -->
<section class="my_account_area pt--80 pb--55 bg--white">
    <div class="container">
        <div class="row">
            {{--{!! $inc_list !!}--}}
            <div class="col-lg-6 col-12">
                <div class="my__account__wrapper">
                    <h3 class="account__title">{{__('login')}}</h3>
                    <form action="{{route('account.login', ['language' => app()->getLocale()])}}">
                        <div class="account__form">
                            <div class="input__box">
                                <label>{{__('Username_email')}} <span>*</span></label>
                                <input name="username_or_email" autofocus  type="text">
                            </div>
                            <div class="input__box">
                                <label>{{__('password')}}<span>*</span></label>
                                <input name="password" type="password">
                            </div>
                            <div class="form__btn">
                                <button data-action="login">{{__('login')}}</button>
                                <label class="label-for-checkbox">
                                    <input id="rememberme" class="input-checkbox" name="remember_me" value="" type="checkbox">
                                    <span>{{__('remember_me')}}</span>
                                </label>
                            </div>
                            <a class="forget_pass" href="#">{{__('lost_your_password')}}</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="my__account__wrapper">
                    <h3 class="account__title">{{__('register')}}</h3>
                    <form action="{{route('account.register', ['language' => app()->getLocale()])}}">
                        <div class="account__form">
                            <div class="input__box">
                                <label>{{__('username')}} <span>*</span></label>
                                <input name="name" type="text" required>
                            </div>
                            <div class="input__box">
                                <label>{{__('email')}} <span>*</span></label>
                                <input name="email" type="email" required>
                            </div>
                            <div class="input__box">
                                <label>{{__('password')}}<span>*</span></label>
                                <input name="password" type="password" required>
                            </div>

                            <div class="input__box">
                                <label>{{__('re_password')}}<span>*</span></label>
                                <input name="re_password" type="password" required>
                            </div>
                            <div class="form__btn">
                                <button data-action="register">{{__('register')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End My Account Area -->
@endsection