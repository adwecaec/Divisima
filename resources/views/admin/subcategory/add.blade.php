@extends('layouts.admin')

@section('content')
    <div class="breadcrumbs admin-bread">
        <ol class="breadcrumb">
            <li><a href="/admin">Панель Адміністратора</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
            <li><a href="/admin/subcategories">Підкатегорії</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
            <li class="active">Додавання</li>
        </ol>
    </div>
<section class="form-add">
    <div class="container">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            {{--<h2>Додавання категорії</h2>--}}
            <form action="{{route('save.subcategory')}}" method="post">
                <div class="add-block">
                    <label for="title-field">Заголовок </label>
                    <input type="text" name="title-field">
                </div>
                <div class="add-block">
                    <label for="name-field">Назва </label>
                    <input type="text" name="name-field">
                </div>
                <div class="add-block">
                    <label for="seo-field">SEO </label>
                    <input type="text" name="seo-field">
                </div>
                <div class="add-block">
                    <label for="cat-field">Група категорій </label>
                        <select size="5" name="cat-field" class="select-option">
                            @foreach($categories as $c)
                                <option value="{{$c->id}}">{{$c->title}}</option>
                            @endforeach
                        </select>
                </div>
                <div class="add-block">
                    <label for="active-field">Активність </label>
                    <input type="checkbox" name="active-field">
                </div>
                <button type="submit" class="btn btn-default todo-btn">Додати</button>

            </form>
        </div>
        <div class="col-sm-2"></div>
    </div>


</section>

@endsection