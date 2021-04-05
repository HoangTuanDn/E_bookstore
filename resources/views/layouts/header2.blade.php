
<header id="wn__header" class="oth-page header__area header__absolute sticky__header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-7 col-lg-2">
                <div class="logo">
                    <a href="{{route('home')}}">
                        <img src="{{asset('fontend/images/logo/logo.png')}}" alt="logo images">
                    </a>
                </div>
            </div>
            <div class="col-lg-8 d-none d-lg-block">
                <nav class="mainmenu__nav">
                    <ul class="meninmenu d-flex justify-content-start">
                        <li class="drop with--one--item"><a href="{{route('home')}}">{{__('home')}}</a></li>
                        <li class="drop"><a href="{{route('home.shop')}}">{{__('shop')}}</a></li>
                        <li class="drop"><a href="shop-grid.html">{{__('books')}}</a>
                            <div class="megamenu mega03">
                                @foreach($parentMenus as $key => $menus)
                                    <ul class="item item03">
                                        <li class="title">{{$key}}</li>
                                        @foreach($menus as $menu)
                                            <li><a href="{{$menu['href']}}">{{$menu['name']}}</a></li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            </div>
                        </li>
                        <li><a href="{{route('home.concat')}}">{{__('contact')}}</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-md-8 col-sm-8 col-5 col-lg-2">
                <ul class="header__sidebar__right d-flex justify-content-end align-items-center">
                    <li class="shop_search"><a class="search__active" href="#"></a></li>
                    <li class="shopcart"><a class="cartbox_active" data-action="show-cart-box" href="{{route('home.cart')}}"><span class="product_qun">{{$totalItemCart}}</span></a>
                        <!-- Start Shopping Cart -->
                        <div class="block-minicart minicart__active">
                        </div>
                        <!-- End Shopping Cart -->
                    </li>
                    <li class="setting__bar__icon"><a class="setting__active" href="#"></a>
                        <div class="searchbar__content setting__block">
                            <div class="content-inner">
                                <div class="switcher-currency">
                                    <strong class="label switcher-label">
                                        <span>{{__('currency')}}</span>
                                    </strong>
                                    <div class="switcher-options">
                                        <div class="switcher-currency-trigger">
                                            <span class="currency-trigger">VND - VN đồng</span>
{{--                                            <ul class="switcher-dropdown">--}}
{{--                                                <li>GBP - British Pound Sterling</li>--}}
{{--                                                <li>EUR - Euro</li>--}}
{{--                                            </ul>--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="switcher-currency">
                                    <strong class="label switcher-label">
                                        <span>{{__('language')}}</span>
                                    </strong>
                                    <div class="switcher-options">
                                        <div class="switcher-currency-trigger">
                                            <span class="currency-trigger">{{__('vn_language')}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="switcher-currency">
                                    <strong class="label switcher-label">
                                        <span>{{__('my_account')}}</span>
                                    </strong>
                                    <div class="switcher-options">
                                        <div class="switcher-currency-trigger">
                                            <div class="setting__menu">
                                                <span><a href="{{route('home.wish_list')}}">{{__('my_wish_list')}}</a></span>
                                                <span><a href="{{route('account.login')}}">{{__('sign_in')}}</a></span>
                                                <span><a href="{{route('account.register')}}">{{__('sign_up')}}</a></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Start Mobile Menu -->
        <div class="row d-none">
            <div class="col-lg-12 d-none">
                <nav class="mobilemenu__nav">
                    <ul class="meninmenu">
                        <li><a href="{{route('home')}}">{{__('home')}}</a></li>

                        <li><a href="{{route('home.shop')}}">{{__('shop')}}</a></li>

                        <li><a href="{{route('home.concat')}}">{{__('contact')}}</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- End Mobile Menu -->
        <div class="mobile-menu d-block d-lg-none">
        </div>
        <!-- Mobile Menu -->
    </div>
</header>