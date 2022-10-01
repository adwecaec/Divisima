@extends('layouts.main')

@section('content')
    @if(!empty($banners) && count($banners) > 0)
        @include('components.banner')
    @endif
    <!--end slider-->
    <section class="features-section">
        <div class="row">
            <div class="col-sm-4">
                <div class="feature-inner">
                    <div class="feature-icon">
                        <img src="/images/home/fitem1.png" alt="">
                    </div>
                    <h2>Швидкі та безпечні платежі</h2>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="feature-inner orange">
                    <div class="feature-icon">
                        <img src="/images/home/fitem2.png" alt="">
                    </div>
                    <h2><b>Преміум товари</b></h2>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="feature-inner">
                    <div class="feature-icon">
                        <img class="pull-left" src="/images/home/fitem3.png" alt="">

                    </div>
                    <h2>Безкоштовна доставка</h2>
                </div>
            </div>
        </div>
    </section>
    <!--start content-->

    <section class="products-section">
        <div class="main-container">
            <div class="row">

                <!--start sidebar-->

                @include('components.sidebar')

                <!--end sidebar-->

                <!-- start products-->

                <div class="col-sm-9 padding-right">
                    <div class="features_items">
                        <h2 class="title text-center">Популярні товари @if($group->seo_name == "women") для жінок@elseif($group->seo_name == "men") для чоловіків@elseif($group->seo_name == "girls") для дівчаток@else для хлопчиків@endif
                        </h2>
                    </div>
                    @include('components.filter')
                    {{--@include('components.ajax-filters')--}}
                    <div class="row">
                        <div class="products">
                            @if(isset($products) && !empty($products) && count($products) > 0)
                                @foreach($products as $item)
                                    @include('components.product')
                                @endforeach
                                @else
                                    <div class="col-sm-12 no-found">
                                        Товари не знайдені.
                                    </div>
                                @endif
                            </div>
                                {{$products->appends(request()->query())->links('components.pagination')}}
                        </div>
                    </div>
                </div>

            </div>
    </section>
@endsection

@section('custom-js')
    {{--<script src="/js/ajax-filters.js"></script>--}}
    {{--<script>--}}
        {{--indexAjax("{{route('index', $group->seo_name)}}");--}}
    {{--</script>--}}
    <script>
        $(document).on('mouseover','.hidden-img', function () {
            $(this).parent().css("background-image", "url('/images/products/" + $(this).attr('id') +  "')");
        });
        $(document).on('mouseout','.hidden-img',function () {
            $(this).parent().css("background-image", "url('/images/products/" + $(this).parent().attr('id') +  "')");
        });
    </script>
    <script src="/js/elastic-filters.js"></script>
@endsection
