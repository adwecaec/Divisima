<div class="row">
        <div class="filters-all">

            <div class="col-sm-6 col-xs-6 col-md-4 col-lg-1 filters ">
                <div class="filter-item">
                    <div class="filter-title">
                        <span>Ціна</span>
                        <img class="filter-img" src="/images/home/arrow-down.png" alt="">
                    </div>
                    <div class="fil-params">
                        <div class="from-to-price">
                            <p class="from-price">Від</p><input class="from-size-input" type="text" name="from-price" required>
                            <p class="to-price">До</p><input  class="to-size-input"type="text" name="to-price" required>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xs-6 col-md-4 col-lg-1 filters"> @if(isset($brands) && !empty($brands))
                    <div class="filter-item">
                        <div class="filter-title">
                            <span id="brand-title">Бренд</span>
                            <img class="filter-img" src="/images/home/arrow-down.png" alt="">
                        </div>
                        <div class="fil-params">
                            <ul>
                                <li class="filter-check brand" data-filter="no"><input class="filter-input" autocomplete="off" id="no-filter-brand" type="checkbox" name="Brand" checked><label for="no-filter-brand">Всі</label></li>
                                @foreach($brands as $b)
                                    <li class="filter-check brand" data-filter="{{$b->seo_name}}-brand"><input class="filter-input" autocomplete="off" id="{{$b->seo_name}}" type="checkbox" name="Brand"><label for="{{$b->seo_name}}">{{$b->name}}</label> </li>
                                @endforeach
                            </ul>

                        </div>
                    </div>
                @endif</div>

            <div class="col-sm-6 col-xs-6 col-md-4 col-lg-1 filters ">@if(isset($colors) && !empty($colors))
                    <div class="filter-item">
                        <div class="filter-title">
                            <span id="color-title">Колір</span>
                            <img class="filter-img" src="/images/home/arrow-down.png" alt="">
                        </div>
                        <div class="fil-params">
                            <ul>
                                <li class="filter-check color" data-filter="no"><input class="filter-input" autocomplete="off" id="no-filter-color" type="checkbox" name="Color" checked><label for="no-filter-color">Всі</label></li>
                                @foreach($colors as $c)
                                    <li class="filter-check color" data-filter="{{$c->seo_name}}-color"><input class="filter-input" autocomplete="off" id="{{$c->seo_name}}" type="checkbox" name="Color"><label for="{{$c->seo_name}}">{{$c->name}}</label> </li>
                                @endforeach
                            </ul>

                        </div>
                    </div>
                @endif</div>

            <div class="col-sm-6 col-xs-6 col-md-4 col-lg-1 filters "> @if(isset($materials) && !empty($materials))
                    <div class="filter-item">
                        <div class="filter-title">
                            <span id="material-title">Матеріал</span>
                            <img class="filter-img" src="/images/home/arrow-down.png" alt="">
                        </div>
                        <div class="fil-params">
                            <ul>
                                <li class="filter-check material" data-filter="no"><input class="filter-input" autocomplete="off" id="no-filter-material" type="checkbox" name="Material" checked><label for="no-filter-material">Всі</label></li>
                                @foreach($materials as $m)
                                    <li class="filter-check material" data-filter="{{$m->seo_name}}-material"><input class="filter-input" autocomplete="off" id="{{$m->seo_name}}" type="checkbox" name="Material"><label for="{{$m->seo_name}}">{{$m->name}}</label> </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif</div>

            <div class="col-sm-6 col-xs-6 col-md-4 col-lg-1 filters"> @if(isset($seasons) && !empty($seasons))
                    <div class="filter-item">
                        <div class="filter-title">
                            <span id="season-title">Сезон</span>
                            <img class="filter-img" src="/images/home/arrow-down.png" alt="">
                        </div>
                        <div class="fil-params">
                            <ul>
                                <li class="filter-check season" data-filter="no"><input class="filter-input" autocomplete="off" id="no-filter-season" type="checkbox" name="Season" checked><label for="no-filter-season">Всі</label></li>
                                @foreach($seasons as $s)
                                    <li class="filter-check season" data-filter="{{$s->seo_name}}-season"><input class="filter-input" autocomplete="off" id="{{$s->seo_name}}" type="checkbox" name="Season"><label for="{{$s->seo_name}}">{{$s->name}}</label></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif</div>

            <div class="col-sm-6 col-xs-6 col-md-4 col-lg-1 filters ">@if(isset($sizes) && !empty($sizes))
                    <div class="filter-item">
                        <div class="filter-title">
                            <span id="size-title">Розмір</span>
                            <img class="filter-img" src="/images/home/arrow-down.png" alt="">
                        </div>
                        <div class="fil-params">
                            <ul>
                                <li class="filter-check size" data-filter="no"><input class="filter-input" autocomplete="off" id="no-filter-size" type="checkbox" name="Size" checked><label for="no-filter-size">Всі</label></li>
                                @foreach($sizes as $si)
                                    <li class="filter-check size" data-filter="{{$si->seo_name}}-size"><input class="filter-input" autocomplete="off" id="{{$si->seo_name}}" type="checkbox" name="Size"><label for="{{$si->seo_name}}">{{$si->name}}</label></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif</div>

                <div class="col-sm-6 col-xs-6 col-md-4 col-lg-1 filters ">
                        <button type="button" class="btn btn-danger btn-danger-filters">Очистити фільтри</button>
                </div>
        </div>
        </div>

<div class="row">
    <div class="col-sm-9 select-order-by filters" >
        <select name="order-by">
            <option value="none" selected >За замовчуванням</option>
            <option value="count">За популярністю</option>
            <option value="price-asc">За зростанням ціни</option>
            <option value="price-desc">За спаданням ціни</option>
            <option value="created_at">За новинками</option>
        </select>
    </div>
</div>