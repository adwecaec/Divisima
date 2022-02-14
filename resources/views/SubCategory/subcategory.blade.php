@extends('layouts.main')
@section('content')

    <section id="advertisement">
        <div class="container">
            <img src="images/shop/advertisement.jpg" alt="" />
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">

                <!--sidebar-->
                @include('parts.sidebar')

                <!--products-->

                <div class="col-sm-9 padding-right">
                    <div class="features_items">
                        <h2 class="title text-center">{{$sub_category->title}}</h2>
                    </div>
                    @include('parts.filters')
                    <div class="products">
                        @foreach($sub_category_products as $item)
                            <div class="col-sm-4 product">
                                <div class="product-image-wrapper">

                                    <!--single product-->
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <a class="product-single" href="{{route('show.product.details',[$group->seo_name, $item->categories['seo_name'], $item->subCategories['seo_name'],$item->seo_name ])}}">
                                                <img src="/images/preview-images/{{$item->preview_img_url}}" alt="" />
                                                <h4>₴{{$item->price}}</h4>
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
                                    {{$sub_category_products->appends(request()->query())->links('parts.pagination')}}
                                </div>
                            </div>
                    </div>
                    <!--end products-->
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
                /* colors array */
                for (let i = 0; i < color.length; i++) {
                    if (color[i].firstChild.checked) {
                        colors = color[i].textContent;
                    }
                }
                /* brands array */

                for (let i = 0; i < brand.length; i++) {
                    if (brand[i].firstChild.checked) {
                        brands = brand[i].textContent;
                    }
                }

                /* materials array */
                for (let i = 0; i < material.length; i++) {
                    if (material[i].firstChild.checked) {
                        materials = material[i].textContent;
                    }
                }

                /* sizes array */
                for (let i = 0; i < size.length; i++) {
                    if (size[i].firstChild.checked) {
                        sizes = size[i].textContent;
                    }
                }
                /* seasons array */
                for (let i = 0; i < season.length; i++) {
                    if (season[i].firstChild.checked) {
                        seasons = season[i].textContent;
                    }
                }

                if ((colors != "") || (brands != "") || (materials != "")  || (seasons != "")  || (sizes != "") ){
                    $.ajax({
                        url: "{{route('show.sub.category', [$group->seo_name, $category->seo_name, $sub_category->seo_name])}}"  ,
                        type: "GET",
                        data: {
                            colors: colors,
                            brands: brands,
                            materials: materials,
                            seasons: seasons,
                            sizes: sizes,
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