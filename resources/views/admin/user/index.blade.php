@extends('layouts.admin')

@section('content')

    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Адмін</a></li>
                    <li class="active">Користувачі</li>
                </ol>
            </div>
            <div class="table-responsive admin-table-index">
                <table class="table table-condensed">
                    <thead>
                    <tr class="admin_menu">
                        <td>ID</td>
                        <td><b>Email</b></td>
                        <td><b>Права</b></td>
                        <td><b>Имя</b></td>
                        <td><b>Телефон</b></td>
                        <td> <b>Активність</b></td>
                        <td><b>Останній вхід</b></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody class="admin-table">

                    @foreach($adm_users as $adm_user)
                        <tr>
                            <td>
                                <p>{{$adm_user->id}}</p>
                            </td>
                            <td>
                                <p>{{$adm_user->email}}</p>
                            </td>
                            <td>
                                <p>{{$adm_user->superuser ? "Админ" : "Користувач"}}</p>
                            </td>
                            <td>
                                <p>{{$adm_user->first_name . ' ' . $adm_user->last_name}}</p>
                            </td>
                            <td>
                                <p>{{$adm_user->phone}}</p>
                            </td>
                            <td>
                                <input type="checkbox" {{$adm_user->active ? "checked" : ""}} disabled>
                            </td>
                            <td>
                                <p>{{$adm_user->last_logged_in}}</p>
                            </td>
                            <td>
                                <form action="{{route('delete.user',$adm_user->id)}}" method="post">
                                    <button id="{{$adm_user->id}}" type="submit" class="btn btn-danger"><svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                                            <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
                                        </svg></button>
                                </form>
                            </td>
                            <td>
                                <a href="{{route('edit.user', $adm_user->id)}}" class="btn btn-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                    </svg></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection