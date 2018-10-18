@extends('study.layout')
@section('content')
    @if (isset($buttons))
    <a href="{{route('admin.new')}}" class="btn btn-success">Создать запись</a>
    @endif
            @foreach($posts as $post)
                <a href="{{route('all.post', ['id' => $post->id])}}">
                    <h2>{{$post->header}}</h2>
                </a>

                @if (isset($buttons))
                    <a href="{{route('admin.edit', ['id' => $post->id])}}" class="btn btn-primary">Редактировать</a>
                    <a href="{{route('admin.unset',['id' => $post->id])}}" class="btn btn-danger">Удалить</a>
                @endif
            @endforeach
@endsection

