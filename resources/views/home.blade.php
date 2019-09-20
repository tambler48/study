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
                <div class="card-header">{{__('Homepage')}}</div>

                <div class="card-body">

                    {{ __('Hello!').' '.Auth::user()->name}}
                        <div>
                            <a href="{{route('user.posts')}}">{{__('View posts')}}</a>
                        </div>

                        @can('view', new \App\User())
                        <div>
                            <a href="{{route('manage.index')}}">{{__('View users')}}</a>
                        </div>
                            @endcan

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
