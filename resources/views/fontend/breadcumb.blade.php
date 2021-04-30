<div class="ht__bradcaump__area bg-image--6">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="bradcaump__inner text-center">
                    <h2 class="bradcaump-title">{{$pageNameLC}}</h2>
                    <nav class="bradcaump-content">
                        <a class="breadcrumb_item" href="{{route('home', ['language' => app()->getLocale()])}}">{{__('home_lc')}}</a>
                        <span class="brd-separetor">/</span>
                        <span class="breadcrumb_item active">{{$pageNameLC}}</span>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>