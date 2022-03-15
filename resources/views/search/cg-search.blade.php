@extends('layouts.main')
@section('content')


    <section class="products-section">
        <div class="main-container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    @if($group->name == "Жінки")
                        <li><a href="/shop/women">Жінкам</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
                    @elseif($group->name == "Чоловіки")
                        <li><a href="/shop/men">Чоловікам</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
                    @elseif($group->name == "Хлопчики")
                        <li><a href="/shop/boys">Хлопчикам</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
                    @elseif($group->name == "Дівчатки")
                        <li><a href="/shop/girls">Дівчаткам</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
                    @endif
                    <li class="active">Пошук: "{{request('q')}}"</li>
                </ol>
            </div>
            <div class="row">

                <!--sidebar-->
            @include('parts.sidebar')

            <!--products-->
                <div class="col-sm-9 padding-right">
                    <div class="features_items">
                        <h2 class="title text-center">Результати пошуку</h2>
                    </div>
                    <div class="row">
                        <div class="col-sm-9 select-order-by filters" >
                            <select name="order-by">
                                <option value="none" selected >За замовчуванням</option>
                                <option value="discount">За знижками</option>
                                <option value="created_at">За новинками</option>
                                <option value="count">За популярністю</option>
                                <option value="price-asc">За зростанням ціни</option>
                                <option value="price-desc">За спаданням ціни</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="products">
                            @if(isset($products) && !empty($products) && count($products) > 0)
                                @foreach($products as $item)
                                    @include('parts.product-item')
                                @endforeach
                            @else
                                <div class="col-sm-12 no-found">
                                    Товари не знайдені.
                                </div>
                            @endif
                        </div>
                        {{$products->appends(request()->query())->links('parts.pagination')}}
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@section('custom-js')
    {{--<script src="/js/ajax-filters.js"></script>--}}
    {{--<script>--}}
        {{--indexAjax("{{route('show.category', [$group->seo_name, $category->seo_name])}}");--}}
    {{--</script>--}}
    <script src="/js/search-page.js"> </script>
@endsection



