@extends('layouts.admin')

@section('content')


    <section class="form-add">
        <div class="container">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                {{--<h2>Додавання категорії</h2>--}}
                <form action="{{route('save.edit.material')}}" method="post">
                    <input type="hidden" name="id" value="{{$material->id}}">
                    <div class="add-block">
                        <label for="name-field">Назва </label>
                        <input type="text" value="{{$material->name}}" name="name-field">
                    </div>
                    <div class="add-block">
                        <label for="seo-field">SEO </label>
                        <input type="text" value="{{$material->seo_name}}" name="seo-field">
                    </div>
                    <div class="add-block">
                        <label for="active-field">Активність </label>
                        <input type="checkbox" name="active-field" {{$material->active ? "checked" : ""}}>
                    </div>
                    <button type="submit" class="btn btn-warning">Зберегти</button>
                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </section>

@endsection