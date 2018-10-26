@extends('layouts.app')

@section('alert')
    @if(isset($alert))
<div class="container">
    @foreach($alert as $key=>$value)
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
        {{ $title ?? 'HELLO'}}
    </h1>

    @yield('block')

</div>
    @endsection