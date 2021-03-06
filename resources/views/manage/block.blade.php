@extends('layouts.container')

@section('block')

    @can('create', new \App\User())
        <div class="card-title">
            <a href="{{route($routePrefix.'.create')}}"
               class="btn btn-success">{{Lang::get('messagesUser.title_create')}}</a>
        </div>
    @endcan

    <div class="row">
        @foreach($data as $item)
            <div class="col-lg-4 col-sm-6 portfolio-item">
                <div class="card h-100">
                    <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                    <div class="card-body">

                        @can('restore', $item)
                            <a href="{{route($routePrefix.'.restore', ['id' => $item->id])}}"
                               class="text-primary">{{__('Restore')}}</a>
                        @endcan

                        @can('remove', $item)
                            <a href="{{route($routePrefix.'.remove', ['id' => $item->id])}}"
                               class="text-secondary">{{__('Remove')}}</a>
                        @endcan

                        @can('update', new \App\User())
                            <a href="{{route($routePrefix.'.edit', ['id' => $item->id])}}"
                               class="text-success">{{__('Edit')}}</a>
                            <form method="POST" action="{{route($routePrefix.'.destroy',['id' => $item->id])}}">
                                <input name="_method" type="hidden" value="DELETE">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-link text-danger">
                                    {{__('Delete')}}
                                </button>
                            </form>
                        @endcan

                        <h4 class="card-title">
                            <a href="{{route($routePrefix.'.show', ['id' => $item->id])}}">
                                @if($item->active === 0)
                                    <s>{{$item->name}}</s>
                                @else
                                    {{$item->name}}
                                @endif
                            </a>
                        </h4>
                        <p class="card-text">{{$item->email}}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection