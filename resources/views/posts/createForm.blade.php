@extends('layout')
@section('content')
    <form method="POST" action="{{route('user.new')}}">
        {{csrf_field()}}
        <input type="hidden" name="user" value="{{$id}}">
        <div class="form-group">
            <label>Заголовок записи</label>
            <input required name="header" type="text" class="form-control" >
        </div>
        <div class="form-group">
            <label>Тело записи</label>
            <textarea required name="body" class="form-control" rows="3"></textarea>
        </div>
        <div class="form-group">
        <button type="submit" class="btn btn-success">Добавить</button>
        </div>
    </form>
@endsection

