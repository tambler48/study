@extends('study.layout')
@section('content')
    <?php  foreach ($posts as $post){  ?>
    <h2> <a href="{{url('/posts/'.$post->id)}}">
        <?= $post->header ?>  </h2>
    </a>

        <?php if(isset($buttons)){ ?>
            <a href="{{url('admin/posts/edit/'.$post->id)}}" class="btn btn-primary">Редактировать</a>
            <a href="{{url('admin/posts/unset/'.$post->id)}}" class="btn btn-danger">Удалить</a>
        <?php } ?>
    <?php } ?>
@endsection

