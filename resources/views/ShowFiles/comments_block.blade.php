 @foreach($commentsGroup as $comment)
     <ul>
        <li>
        <img src="{{asset('104437.jpg')}}" class="image float-left">
    <div class="col-10 text-left d-inline-block" data-commentId="{{$comment['id']}}">

        <span>{{$authorComment[$comment['id']]['name']}}</span>
        <p>{{$comment['content']}}</p>
        <p><span>{{$comment['created_at']}}</span><i class="fa fa-reply offset-6"></i> </p>
    </div>
<hr>
        @if(isset($comments[$comment['id']]) )
            <ul>
            @include('ShowFiles.comments_block',['commentsGroup'=>$comments[$comment['id']]])
            </ul>
        @endif
</li></ul>
        @endforeach

