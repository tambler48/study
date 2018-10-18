@extends('study.layout')
@section('content')
    <form method="POST" action="{{url('/admin/posts/edit/')}}">
        {{csrf_field()}}
        <input type="hidden" name="user" value="<?= $user?>">
        <input type="hidden" name="post_id" value="<?= $post->id?>">
        <div class="form-group">
            <label>Заголовок записи</label>
            <input required name="header" type="text" class="form-control" value="<?= $post->header?>">
        </div>
        <div class="form-group">
            <label>Тело записи</label>
            <textarea required name="body" class="form-control" rows="3"><?= $post->body?></textarea>
        </div>
        <div class="form-group">
        <button type="submit" class="btn btn-primary">Изменить</button>
        </div>
    </form>
@endsection
