@extends('layouts.container')
@section('block')

    <form method="POST" action="{{route($routePrefix.'.new')}}">
        {{csrf_field()}}
        <input type="hidden" name="user_id" value="{{$id}}">
        <div class="form-group">
            <label>{{Lang::get('messagesPost.form_head')}}</label>
            <input required name="header" type="text" class="form-control" >
        </div>
        <div class="form-group">
            <label>{{Lang::get('messagesPost.form_body')}}</label>
            <textarea required name="body" class="form-control" rows="3"></textarea>
        </div>
        <div class="form-group">
        <button type="submit" class="btn btn-success">{{__('Save')}}</button>
        </div>
    </form>

@endsection

