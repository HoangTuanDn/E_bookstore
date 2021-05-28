@extends('layouts.master')

@section('title')
    <title>{{'Home | '. 'Wishlist'}}</title>
@endsection

@section('js')
    <script src="{{asset('fontend/common/wishlist.js')}}"></script>
@endsection

@section('content')
<!-- Start Bradcaump area -->
<div class="ht__bradcaump__area bg-image--5">
    @include('fontend.breadcumb',['pageNameLC' => __('wishlist')])
</div>
<!-- End Bradcaump area -->
<!-- cart-main-area start -->
<div class="wishlist-area section-padding--lg bg__white">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="wishlist-content">
                    <form action="#">
                        <input type="hidden" value="{{$allProducts}}">
                        <input type="hidden" class="stock_true" value="{{__('stock_true')}}">
                        <input type="hidden" class="stock_false" value="{{__('stock_false')}}">
                        <input type="hidden" class="add_text" value="{{__('add_to_cart_1')}}">
                        <input type="hidden" class="delete_wishlist_text" value="{{__('delete_product_ind_wishlist')}}">
                        <input type="hidden" class="url_store" value="{{route('home.cart.store', ['language' => app()->getLocale()])}}">
                        <div class="wishlist-table wnro__table table-responsive">
                            <table>
                                <thead>
                                <tr>
                                    <th class="product-remove"></th>
                                    <th class="product-thumbnail"></th>
                                    <th class="product-name"><span class="nobr">{{__('sort_name_product')}}</span></th>
                                    <th class="product-price"><span class="nobr"> {{__('price')}} </span></th>
                                    <th class="product-stock-stauts"><span class="nobr"> {{__('stock_status')}} </span></th>
                                    <th class="product-add-to-cart"></th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- cart-main-area end -->
@endsection