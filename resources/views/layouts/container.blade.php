@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">
        {{ $title ?? 'HELLO'}}
    </h1>

    @yield('block')

</div>
    @endsection