@extends('layouts.container')

@section('block')
    <div class="card container jumbotron">
        <div class="card-body ">
            <h1 class="card-title">{{$data->header}}</h1>
            <p class="card-text">{{$data->body}}</p>
        </div>
    </div>
@endsection

