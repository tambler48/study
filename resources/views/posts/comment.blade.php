@section('comments')

    <div class="media-block">

        @if(session('editComment'))

            <form method="POST" action="{{route('comment.update', ['id' => session('editComment')->id])}}">
                {{csrf_field()}}
                <input name="_method" type="hidden" value="PUT">
                <input type="hidden" name="user_id" value="{{session('editComment')->user_id}}">
                <input type="hidden" name="post_id" value="{{session('editComment')->post_id}}">
                <div class="form-group">
                    <label>{{Lang::get('messagesPost.add_comment')}}</label>
                    <textarea required name="body" class="form-control"
                              placeholder="{{Lang::get('messagesPost.write_comment')}}" rows="3">{{session('editComment')->body}}</textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                </div>
            </form>

        @else
            @can('create', new \App\Comment())
                <form method="POST" action="{{route('comment.store')}}">
                    {{csrf_field()}}

                    <input type="hidden" name="user_id" value="{{Auth::id()}}">
                    <input type="hidden" name="post_id" value="{{$data->id}}">
                    <div class="form-group">
                        <label>{{Lang::get('messagesPost.add_comment')}}</label>
                        <textarea required name="body" class="form-control"
                                  placeholder="{{Lang::get('messagesPost.write_comment')}}" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                    </div>
                </form>
            @endcan
        @endif
        @foreach($comments as $comment)

            <div class="card-body">
                <div class="mar-btm">
                    <a href="#" class="btn-link text-semibold media-heading box-inline">
                        <h4>{{$comment->hasOne('App\User', 'id', 'user_id')->getResults()->name}}</h4></a>
                    @can('update', $comment)
                        <a href="{{route('comment.edit', ['id' => $comment->id])}}"
                           class="text-success">{{__('Edit')}}</a>

                        <form method="POST" action="{{route('comment.destroy', ['id' => $comment->id])}}">
                            <input name="_method" type="hidden" value="DELETE">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-link text-danger">
                                {{__('Delete')}}
                            </button>
                        </form>
                    @endcan
                    <p class="text-muted text-sm"><i class="fa fa-mobile fa-lg"></i>{{$comment->updated_at}}</p>

                </div>
                <p>{{$comment->body}}</p>
                <hr>

            </div>
        @endforeach

    </div>

@endsection

