@extends('layouts.container')

@section('block')
    <div class="container">
        <div class="jumbotron">
            <h1>{{$post->header}}</h1>
            <p>{{$post->body}}</p>
        </div>
    </div>
@endsection

