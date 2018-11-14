@extends('layouts.container')
@section('block')
    <form method="POST" action="{{route($routePrefix.'.edit')}}">
        {{csrf_field()}}

        <input type="hidden" name="user_id" value="{{$id}} ">
        <input type="hidden" name="post_id" value="{{$post->id}}">
        <div class="form-group">
            <label>{{Lang::get('messagesPost.form_head')}}</label>
            <input required name="header" type="text" class="form-control" value="{{$post->header}}">
        </div>
        <div class="form-group">
            <label>{{Lang::get('messagesPost.form_body')}}</label>
            <textarea required name="body" class="form-control" rows="3">{{$post->body}}</textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
        </div>
    </form>
@endsection

