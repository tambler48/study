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
    <h1 class="my-4">
        {{ $title ?? ''}}
    </h1>

    @yield('block')

</div>
    @endsection