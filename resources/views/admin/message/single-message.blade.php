@extends('layouts.admin')

@section('content')

    @if(isset($breadcrumbs))
        @include('admin.components.breadcrumbs')
    @endif
    <section class="form-add">
        <div class="container">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                {{--<h2>Додавання категорії</h2>--}}
                <div class="add-block">
                    <label for="user-field">ID користувача </label>
                    <input type="text" value="{{!empty($message->user_id) ? $message->user_id : ""}}" name="user-field" readonly>
                </div>
                <div class="add-block">
                    <label for="mail-field">Ел. пошта </label>
                    <input type="text" value="{{$message->email}}" name="mail-field" readonly>
                </div>
                <div class="add-block">
                    <label for="theme-field">Тема </label>
                    <input type="text" value="{{$message->theme}}" name="theme-field" readonly>
                </div>
                <div class="add-block">
                    <label for="message-field">Повідомлення </label>
                    <textarea  rows="10" name="message-field" readonly>{{$message->message}}</textarea>
                </div>
                <div class="add-block">
                    <label for="date-field">Дата </label>
                    <input type="text" value="{{date("d.m.Y - H:i", strtotime($message->created_at))}}" name="date-field" readonly>
                </div>
                    <a href="/admin/messages"><button type="button" class="btn btn-default todo-btn">Назад</button></a>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </section>

@endsection
