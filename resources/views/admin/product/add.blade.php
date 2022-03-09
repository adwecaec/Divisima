@extends('layouts.admin')

@section('content')
    <div class="breadcrumbs admin-bread">
        <ol class="breadcrumb">
            <li><a href="/admin">Панель Адміністратора</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
            <li><a href="/admin/products">Продукти</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
            <li class="active">Додавання</li>
        </ol>
    </div>
    <section class="form-add">
        <div class="container">
            <div class="col-sm-2"></div>
            <div class="col-sm-9">
                {{--<h2>Додавання категорії</h2>--}}
                <form action="{{route('save.product')}}" method="post">
                    <div class="add-block">
                        <label for="name-field">Назва* </label>
                        <input type="text" name="name-field">
                    </div>
                    <div class="add-block">
                        <label for="seo-field">SEO* </label>
                        <input type="text" name="seo-field">
                    </div>
                    <div class="add-block">
                        <label for="image-field">Посилання на зображення* </label>
                        <input type="text" name="image-field">
                    </div>
                    <div class="add-block">
                        <label for="description-field">Опис* </label>
                        <textarea rows="10" name="description-field"> </textarea>
                    </div>
                    <div class="add-block">
                        <label for="price-field">Ціна* </label>
                        <input type="text" name="price-field">
                    </div>
                    <div class="add-block">
                        <label for="discount-field">Знижка (%) </label>
                        <input type="text" name="discount-field">
                    </div>
                    <div class="add-block">
                        <label for="banner-field">Акція(якщо є)</label>
                        <select size="5" name="banner-field" class="select-option">
                            @foreach($banners as $banner)
                                <option value="{{$banner->id}}">{{$banner->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="count-field">Кількість* </label>
                        <input type="text" name="count-field">
                    </div>
                    <div class="add-block">
                        <label for="active-field">Активність </label>
                        <input type="checkbox" name="active-field">
                    </div>
                    <div class="add-block">
                        <label for="cat-field">Група категорій* </label>
                        <select size="4" name="cat-field" class="select-option">
                            @foreach($category_groups as $g)
                                <option value="{{$g->id}}">{{$g->name}}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="add-block">
                        <label for="category-field">Категорія* </label>
                        <select size="7" name="category-field" class="select-option">
                            @foreach($categories as $c)
                                <option value="{{$c->id}}">{{$c->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="sub-category-field">Підкатегорія* </label>
                        <select size="7" name="sub-category-field" class="select-option">
                            @foreach($sub_categories as $sc)
                                <option value="{{$sc->id}}">{{$sc->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="color-field">Колір* </label>
                        <select size="7" name="color-field" class="select-option">
                            @foreach($colors as $col)
                                <option value="{{$col->id}}">{{$col->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="season-field">Сезон* </label>
                        <select size="7" name="season-field" class="select-option">
                            @foreach($seasons as $s)
                                <option value="{{$s->id}}">{{$s->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="brand-field">Бренд* </label>
                        <select size="7" name="brand-field" class="select-option">
                            @foreach($brands as $b)
                                <option value="{{$b->id}}">{{$b->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block add-materials">
                        <label for="">Матеріал* </label>
                        <div class="inputs-block">
                                @foreach($materials as $m)
                                <div class="input-block-item">
                                    <input id="{{$m->seo_name}}" name="materials[]" type="checkbox" value="{{$m->id}}" class="many-input">
                                    <label class="many-input-label" for="{{$m->seo_name}}">{{$m->name}}</label>
                                </div>
                                @endforeach
                        </div>
                    </div>
                    <div class="add-block add-sizes">
                        <label for="">Розмір* </label>
                        <div class="inputs-block">
                            @foreach($sizes as $si)
                                <div class="input-block-item">
                                        <input id="{{$si->seo_name}}" name="sizes[]" type="checkbox" value="{{$si->id}}" class="many-input">
                                        <label class="many-input-label" for="{{$si->seo_name}}">{{$si->name}}</label>
                                        <p class="input-count-p">Кількість (шт.): </p><input type="text" class="input-count" value="" name="size-count[]">
                                </div>

                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="btn btn-default todo-btn">Додати</button>

                </form>

            </div>
            <div class="col-sm-2"></div>
        </div>

    </section>

@endsection
{{--@section('custom-js')--}}

    {{--<script>--}}
        {{--$('input[name="sizes\[\]"]').change(function () {--}}
            {{----}}
        {{--});--}}
    {{--</script>--}}
    {{--@endsection--}}