@extends('layouts.app')


@section('alert')
    @if(session('alert'))
        <div class="container">
            @foreach(session('alert') as $key=>$value)
                <div class="alert alert-danger">
                    <strong>{{$key}}</strong>
                    <ul>
                        @foreach($value as $message)
                            <li>
                                {{$message}}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    @endif
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">

                    Добро пожаловать, {{Auth::user()->name}}
                        <div>
                            <a href="{{route('user.posts')}}">Просмотр записей</a>
                        </div>

                        @if((\Illuminate\Support\Facades\Auth::user())->role_id === 1)
                        <div>
                            <a href="{{route('manage.index')}}">Просмотр пользователей</a>
                        </div>
                            @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
