@extends('layout')
@section('content')
    <form method="{{$meth}}" action="{{url($url)}}">
        {{ method_field($meth) }}
        @if (isset($post->id))
            <input type="hidden" name="post_id" value="{{$post->id}}">
        @endif
        <input type="hidden" name="user_id" value="{{$idUser}}">
        <div class="form-group">
            <label>Заголовок записи</label>
            <input required name="header" type="text" class="form-control" value="{{$post->header ?? ''}}" >
        </div>
        <div class="form-group">
            <label>Тело записи</label>
            <textarea required name="body" class="form-control" rows="3">{{$post->body ?? ''}}</textarea>
        </div>
        <div class="form-group">
        <button type="submit" class="btn btn-success">Добавить</button>
        </div>
    </form>
@endsection

