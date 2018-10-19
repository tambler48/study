@extends('layout')
@section('content')
    @if (isset($buttons))
    <a href="{{route('user.new')}}" class="btn btn-success">Создать запись</a>
    @endif
            @foreach($posts as $post)
                <a href="{{route('all.post', ['id' => $post->id])}}">
                    <h2>{{$post->header}}</h2>
                </a>

                @if (isset($buttons))
                    <a href="{{route('user.edit', ['id' => $post->id])}}" class="btn btn-primary">Редактировать</a>
                    <a href="{{route('user.unset',['id' => $post->id])}}" class="btn btn-danger">Удалить</a>
                @endif
            @endforeach
@endsection

