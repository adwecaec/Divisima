@extends('layouts.admin')

@section('content')
    <div class="breadcrumbs admin-bread">
        <ol class="breadcrumb">
            <li><a href="/admin">Панель Адміністратора</a> </li>
            <li><a href="/admin/brands">Бренди</a> </li>
            <li class="active">Додавання</li>
        </ol>
    </div>
    <section class="form-add">
        <div class="container">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                {{--<h2>Додавання категорії</h2>--}}
                <form action="{{route('brands.store')}}" method="post">
                    <div class="add-block">
                        <label for="name">Назва* </label>
                        <input type="text" name="name" required maxlength="15">
                    </div>
                    @if($errors->has('name'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="seo_name">SEO* </label>
                        <input type="text" name="seo_name" required maxlength="15">
                    </div>
                    @if($errors->has('seo_name'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('seo_name') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="active">Активність </label>
                        <input type="checkbox" name="active">
                    </div>
                    <button type="submit" class="btn btn-default todo-btn">Додати</button>

                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>


    </section>

@endsection
