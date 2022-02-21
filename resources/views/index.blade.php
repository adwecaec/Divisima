@extends('layouts.main')

@section('content')
    <section id="slider">
        <div class="container-sm">
            <div class="row">
                <div class="col-sm-12">

                    <div
                            id="slider-carousel"
                            class="carousel slide"
                            data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach($banners as $key => $value)
                                @if($key == 0)
                                <li data-target="#slider-carousel" data-slide-to="{{$value->id-1}}" class="active"></li>
                                @else
                                 <li data-target="#slider-carousel" data-slide-to="{{$value->id-1}}"></li>
                                @endif
                            @endforeach
                                <li data-target="#slider-carousel" style="visibility: hidden" data-slide-to="{{$value->id}}"></li>
                        </ol>
                        <div class="carousel-inner">
                            @foreach($banners as $key => $value)
                                @if($key == 0)
                                    <div class="item active">
                                        <div class="col-sm-12">
                                            <img src="/images/home/{{$value->image_url}}" class="girl img-responsive" alt="" />
                                            @if(isset($value->mini_img_url) && !empty($value->mini_img_url))
                                            <img src="/images/home/{{$value->mini_img_url}}" class="pricing" alt="" />
                                            @endif
                                            <div class="slider-text">
                                                <h3>{{$value->title}}</h3>
                                                <p>{{$value->description}}</p>
                                                {{--<button type="button" class="btn btn-warning"><a href="{{$value->details_url}}">Додати</a></button>--}}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="item">
                                        <div class="col-sm-12">
                                            <img src="/images/home/{{$value->image_url}}" class="girl img-responsive" alt="" />
                                            @if(isset($value->mini_img_url) && !empty($value->mini_img_url))
                                                <img src="/images/home/{{$value->mini_img_url}}" class="pricing" alt="" />
                                            @endif
                                            <div class="slider-text">
                                                <h3>{{$value->title}}</h3>
                                                <p>{{$value->description}}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                        <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

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
        <div class="container">
            <div class="row">

                <!--start sidebar-->

                @include('parts.sidebar')

                <!--end sidebar-->

                <!-- start products-->

                <div class="col-sm-9 padding-right">
                    <div class="features_items">
                        <h2 class="title text-center">Популярні товари @if($group->seo_name == "women") для жінок@elseif($group->seo_name == "men") для чоловіків@elseif($group->seo_name == "girls") для дівчаток@else для хлопчиків@endif
                        </h2>
                    </div>
                    @include('parts.filters')
                    <div class="row">
                        <div class="col-sm-9 select-order-by" >
                            <select name="order-by">
                                <option value="none" selected >За замовчуванням</option>
                                <option value="count">За популярністю</option>
                                <option value="price-asc">За зростанням ціни</option>
                                <option value="price-desc">За спаданням ціни</option>
                                <option value="created_at">За новинками</option>
                            </select>
                        </div>
                    </div>
                    <div class="products">
                        @foreach($group_products as $item)
                            <div class="col-sm-4 product">
                                <div class="product-image-wrapper">

                                    <!--single product-->
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <a class="product-single" href="{{route('show.product.details',[$group->seo_name, $item->categories['seo_name'], $item->subCategories['seo_name'],$item->seo_name ])}}">
                                                <img src="/images/preview-images/{{$item->preview_img_url}}" alt="" />
                                               @if(isset($item->discount) && !empty($item->discount))
                                                   <div class="product-single-prices">
                                                       <span class="product-single-old-price">₴{{$item->price}}</span>
                                                       <span class="product-single-discount">₴{{$item->price - (round($item->price * ($item->discount * 0.01)))}}</span>
                                                   </div>
                                                   @else
                                                    <h4>₴{{$item->price}}</h4>
                                                   @endif
                                                <h5><strong>{{$item->brands['name']}}</strong> / {{$item->name}}</h5>
                                            </a>
                                            <span class="sizes-info"><strong>Розміри:</strong>
                                            @foreach($item->sizes as $s)
                                                    {{ $s->name}};
                                            @endforeach
                                            </span>
                                        </div>
                                    </div>
                                    <div class="choose">
                                        <ul class="nav nav-pills nav-justified">
                                            <li>
                                                <a href="{{route('show.product.details',[$group->seo_name, $item->categories['seo_name'], $item->subCategories['seo_name'],$item->seo_name ])}}"><i class="fa fa-star"></i> Переглянути</a>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                            <div class="row">
                                <div class="col-sm-9">
                                    {{$group_products->appends(request()->query())->links('parts.pagination')}}
                                </div>
                            </div>
                    </div>
                    </div>
                </div>

            </div>
    </section>
@endsection

@section('custom-js')
    <script>
        $(document).ready(function() {

            $(document).mouseup( function(e){
                var div = $( ".filter-item" );
                if ( !div.is(e.target)
                    && div.has(e.target).length === 0 ) {
                    div.find('.fil-params').removeClass('fil-active');
                    div.find('.filter-img').attr('src', '/images/home/arrow-down.png')
                }
            });

            let color = document.querySelectorAll('.color');
            let brand = document.querySelectorAll('.brand');
            let material = document.querySelectorAll('.material');
            let season = document.querySelectorAll('.season');
            let size = document.querySelectorAll('.size');

            var brands  = "" , colors  = "" , materials  = "", seasons  = "", sizes  = "";

            $('.color').find('input[type="checkbox"]').change(function () {
                $('.color').find('input[type="checkbox"]').not(this).prop('checked', false);
            });

            $('.brand').find('input[type="checkbox"]').change(function () {
                $('.brand').find('input[type="checkbox"]').not(this).prop('checked', false);
            });

            $('.material').find('input[type="checkbox"]').change(function () {
                $('.material').find('input[type="checkbox"]').not(this).prop('checked', false);
            });
            $('.season').find('input[type="checkbox"]').change(function () {
                $('.season').find('input[type="checkbox"]').not(this).prop('checked', false);
            });
            $('.size').find('input[type="checkbox"]').change(function () {
                $('.size').find('input[type="checkbox"]').not(this).prop('checked', false);
            });

            $('.btn-info').click(function () {
                let orderBy = $('select[name="order-by"]').val();
                let from_price = parseInt($('input[name="from-price"]').val());
                let to_price = parseInt($('input[name="to-price"]').val());
                /* colors array */
                for (let i = 0; i < color.length; i++) {
                    if (color[i].firstChild.checked) {
                        colors = color[i].textContent;
                        if(colors != "Всі") {
                            document.getElementById('color-title').textContent = "Колір (1)";
                        }else{
                            document.getElementById('color-title').textContent = "Колір";                        }
                    }
                }
                /* brands array */

                for (let i = 0; i < brand.length; i++) {
                    if (brand[i].firstChild.checked) {
                        brands = brand[i].textContent;
                        if(brands != "Всі") {
                            document.getElementById('brand-title').textContent = "Бренд (1)";
                        }else{
                            document.getElementById('brand-title').textContent = "Бренд";
                        }
                    }
                }

                /* materials array */
                for (let i = 0; i < material.length; i++) {
                    if (material[i].firstChild.checked) {
                        materials = material[i].textContent;
                        if(materials != "Всі") {
                            document.getElementById('material-title').textContent = "Матеріал (1)";
                        }else{
                            document.getElementById('material-title').textContent = "Матеріал";
                        }
                    }
                }

                /* sizes array */
                for (let i = 0; i < size.length; i++) {
                    if (size[i].firstChild.checked) {
                        sizes = size[i].textContent;
                        if(sizes != "Всі") {
                            document.getElementById('size-title').textContent = "Розмір (1)";
                        }else{
                            document.getElementById('size-title').textContent = "Розмір";
                        }
                    }
                }
                /* seasons array */
                for (let i = 0; i < season.length; i++) {
                    if (season[i].firstChild.checked) {
                        seasons = season[i].textContent;
                        if(seasons != "Всі"){
                            document.getElementById('season-title').textContent = "Сезон (1)";
                        }else{
                            document.getElementById('season-title').textContent = "Сезон";
                        }
                    }
                }

                if ((colors != "") || (brands != "") || (materials != "")  || (seasons != "")  || (sizes != "") || !isNaN(from_price) || !isNaN(to_price)){
                    $.ajax({
                        url: "{{route('index', $group->seo_name)}}"  ,
                        type: "GET",
                        data: {
                            colors: colors,
                            brands: brands,
                            materials: materials,
                            seasons: seasons,
                            sizes: sizes,
                            orderBy: orderBy,
                            from_price: !isNaN(from_price) ? from_price : 0,
                            to_price: !isNaN(to_price) || to_price == 0 ? to_price : 1000000
                            // countries: countries
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: (data) =>{
                            $('.products').html(data)
                        }

                    });
                }

            })
        })
    </script>
@endsection