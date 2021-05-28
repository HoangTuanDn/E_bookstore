@extends('layouts.master')

@section('js')
    <script src="{{asset('fontend/common/account.js')}}"></script>
@endsection

@section('content')
    <!-- Start Bradcaump area -->
    <div class="ht__bradcaump__area bg-image--6">
        @include('fontend.breadcumb',['pageNameLC' => __('my_account')])
    </div>
    <!-- End Bradcaump area -->
    <!-- Start My Account Area -->
    <section class="my_account_area pt--80 pb--55 bg--white d-flex">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-7 col-12">
                    <div class="my__account__wrapper">
                        <h3 class="account__title">{{__('forgot_password')}} ?</h3>
                        <form action="{{route('account.sendLink', ['language' => app()->getLocale()])}}">
                            <div class="account__form d-flex flex-column">
                                <div class="input__box">
                                    <label>{{__('email')}} <span>*</span></label>
                                    <input name="email" autofocus  type="email">
                                </div>

                                <div class="form__btn mt--20 ">
                                    <button data-action="send-link-password">{{__('send_link_reset_password')}}</button>
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



