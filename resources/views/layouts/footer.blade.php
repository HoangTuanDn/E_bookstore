<footer id="wn__footer" class="footer__area bg__cat--8 brown--color">
    <div class="footer-static-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer__widget footer__menu">
                        <div class="ft__logo">
                            <a href="index.html">
                                <img src="{{asset('fontend/images/logo/3.png')}}" alt="logo">
                            </a>
                            <p>{{__('footer_detail')}}</p>
                        </div>
                        <div class="footer__content">
                            <ul class="social__net social__net--2 d-flex justify-content-center">
                                <li><a href="#"><i class="bi bi-facebook"></i></a></li>
                                <li><a href="#"><i class="bi bi-twitter"></i></a></li>
                                <li><a href="#"><i class="bi bi-youtube"></i></a></li>
                            </ul>
                            <ul class="mainmenu d-flex justify-content-center">
                                <li><a href="{{route('home', ['language' => app()->getLocale()]) . '#nav-adventure'}}">{{__('trending')}}</a></li>
                                <li><a href="{{route('home', ['language' => app()->getLocale()]) . '#best-sell'}}">{{__('best_seller_lc')}}</a></li>
                                <li><a href="{{route('home', ['language' => app()->getLocale()]) . '#nav-all'}}">{{__('all_lc')}}</a></li>
                                <li><a href="{{route('home.wish_list', ['language' => app()->getLocale()])}}">{{__('wishlist')}}</a></li>
                                <li><a href="{{route('home.concat', ['language' => app()->getLocale()])}}">{{__('contact_l')}}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright__wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="copyright">
                        <div class="copy__right__inner text-left">
                            <p>Copyright <i class="fa fa-copyright"></i> <a href="https://freethemescloud.com/">Free themes Cloud.</a> Custom by Dn</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="payment text-right">
                        <img src="{{asset('fontend/images/icons/payment.png')}}" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>