@extends('layouts.master')

@section('js')
    <script src="{{asset('fontend/common/wishlist.js')}}"></script>
@endsection

@section('content')
<!-- Start Bradcaump area -->
<div class="ht__bradcaump__area bg-image--5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="bradcaump__inner text-center">
                    <h2 class="bradcaump-title">Wishlist</h2>
                    <nav class="bradcaump-content">
                        <a class="breadcrumb_item" href="index.html">Home</a>
                        <span class="brd-separetor">/</span>
                        <span class="breadcrumb_item active">Wishlist</span>
                    </nav>
                </div>
            </div>
        </div>
    </div>
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
                        <input type="hidden" class="stock_false" value="{{__('stock_fasle')}}">
                        <input type="hidden" class="add_text" value="{{__('add_to_cart_1')}}">
                        <input type="hidden" class="delete_wishlist_text" value="{{__('delete_product_ind_wishlist')}}">
                        <input type="hidden" class="url_store" value="{{route('home.cart.store')}}">
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
                                <tr>
                                    <td class="product-remove"><a href="#">×</a></td>
                                    <td class="product-thumbnail"><a href="#"><img src="{{asset('fontend/images/product/sm-3/1.jpg')}}" alt=""></a></td>
                                    <td class="product-name"><a href="#">Natoque penatibus</a></td>
                                    <td class="product-price"><span class="amount">$165.00</span></td>
                                    <td class="product-stock-status"><span class="wishlist-in-stock">In Stock</span></td>
                                    <td class="product-add-to-cart"><a href="#"> Add to Cart</a></td>
                                </tr>

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