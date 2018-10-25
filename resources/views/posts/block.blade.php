@extends('layouts.container')
@section('block')
    @if (isset($buttons))
        <div class="card-title">
        <a href="{{route('user.new')}}" class="btn btn-success">Создать запись</a>
        </div>
    @endif
    <div class="row">
    @foreach($data as $item)
<div class="col-lg-4 col-sm-6 portfolio-item">
    <div class="card h-100">
        <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
        <div class="card-body">

            @if (isset($buttons))
                <a href="{{route('user.edit', ['id' => $item->id])}}" class="text-success">Редактировать</a>
                <a href="{{route('user.unset',['id' => $item->id])}}" class="text-danger">Удалить</a>
            @endif

            <h4 class="card-title">
                <a href="{{route('all.post', ['id' => $item->id])}}">{{$item->header}}</a>
            </h4>
            <p class="card-text">{{$item->body}}</p>
        </div>
    </div>
</div>
    @endforeach
    </div>
    @endsection