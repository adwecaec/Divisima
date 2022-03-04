@extends('layouts.admin')

@section('content')

<section class="form-add">
    <div class="container">
        <div class="col-sm-2"></div>
        <div class="col-sm-9">
            {{--<h2>Додавання категорії</h2>--}}
            <form action="{{route('save.banner')}}" method="post">
                <div class="add-block">
                    <label for="title-field">Заголовок </label>
                    <input type="text" name="title-field">
                </div>
                <div class="add-block">
                    <label for="description-field">Опис </label>
                    <input type="text" name="description-field">
                </div>
                <div class="add-block">
                    <label for="description-field">SEO </label>
                    <input type="text" name="seo-field">
                </div>
                <div class="add-block">
                    <label for="mini-img-field">Міні-зображення (справа) </label>
                    <input type="text" name="mini-img-field">
                </div>
                <div class="add-block">
                    <label for="main-img-field">Головне зображення (справа) </label>
                    <input type="text" name="main-img-field">
                </div>
                <div class="add-block">
                    <label for="active-field">Активність </label>
                    <input type="checkbox" name="active-field">
                </div>
                <div class="add-block">
                    <label for="cat-field">Група категорій </label>
                    <select size="5" name="cat-field" class="select-option">
                        @foreach($category_groups as $group)
                            <option value="{{$group->id}}">{{$group->name}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-default todo-btn">Додати</button>

            </form>
        </div>
        <div class="col-sm-1"></div>
    </div>


</section>

@endsection