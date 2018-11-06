@extends('layouts.container')

@section('block')

    <div class="card-title">
        <a href="{{route($routePrefix.'.create')}}" class="btn btn-success">Создать пользователя</a>
    </div>

    <div class="row">
        @foreach($data as $item)
            <div class="col-lg-4 col-sm-6 portfolio-item">
                <div class="card h-100">
                    <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                    <div class="card-body">


                        <a href="{{route($routePrefix.'.edit', ['id' => $item->id])}}" class="text-success">Редактировать</a>

                        <form method="POST" action="{{route($routePrefix.'.destroy',['id' => $item->id])}}">
                            <input name="_method" type="hidden" value="DELETE">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-link text-danger">
                                Удалить
                            </button>
                        </form>


                        <h4 class="card-title">
                            <a href="{{route($routePrefix.'.show', ['id' => $item->id])}}">{{$item->name}}</a>
                        </h4>
                        <p class="card-text">{{$item->email}}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection