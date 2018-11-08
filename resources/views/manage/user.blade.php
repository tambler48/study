@extends('layouts.container')

@section('block')
    <table class="table">
        <thead class="thead-light">
        <tr>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
            <th scope="col">Api token</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{$data->name}}</td>
            <td>{{$data->email}}</td>
            <td>{{$data->hasOne('App\Role', 'id', 'role_id')->getResults()->name}}</td>

            @if(isset($data->api_token))
                <td>{{$data->api_token}}</td>
                @else
                <td>NULL</td>
            @endif
        </tr>
        </tbody>
    </table>
@endsection
