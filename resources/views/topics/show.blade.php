@extends('layouts.app')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $topic->title }}</h4>
            <p class="card-text">{{ $topic->content }}</p>
            <div class="d-flex justify-content-between align-items-center">
                <small>Posted at:  {{date('d/m/Y H:i:s', strtotime($topic->created_at))}}</small>
                <span class="badge badge-primary">{{ $topic->user->name }}</span>

                </div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                        @can('update', $topic)
                        <a href="{{route('topics.edit', $topic->id)}}" class="btn btn-warning" >Edit </a>
                        @endcan
                        @can('delete', $topic)
                        <form action ="{{route('topics.delete', $topic->id)}}" method="GET">
                        @csrf
                        {{-- @Method('DELETE') --}}
                        <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        @endcan
    </div>
        </div>

    </div>
    <hr>
    <h5>Comments</h5>
    @forelse ($topic->comments as $comment)
        <div class="card mb-2">
        <div class="card-body">
        <div>{{$comment->content}}
        <div class="d-flex justify-content-between align-items-center">
        <small>Posted at: {{$comment->created_at->format('d/m/Y  H:i:m')}}</small>
        <span class="badge badge-primary">{{$comment->user->name}}</span>

        </div>
        </div>
        <div>
        {{-- <div  class="btn btn-success" onclick="markAsSolution('{{$topic->id}}','{{$comment->id}}',this)">Mark as solution</div> --}}
        {{-- <button type="button" class="btn btn-success" id="markbtn" topic-id="{{$topic->id}}" comment-id="{{$comment->id}}">Mark As Solution</button> --}}
        </div>

                {{-- <h4 class="card-title">Title</h4>
                <p class="card-text">Text</p> --}}
            </div>
        </div>
        @foreach ($comment->comments as $replyComment)
        <div class="card mb-2 ml-5">
        <div class="card-body">
            {{$replyComment->content}}
        <div class="d-flex justify-content-between align-items-center">
        <small>Posted at: {{$replyComment->created_at->format('d/m/Y  H:i:m')}}</small>
        <span class="badge badge-primary">{{$replyComment->user->name}}</span>

        </div>
                {{-- <h4 class="card-title">Title</h4>
                <p class="card-text">Text</p> --}}
            </div>
        </div>

        @endforeach
        @auth
        <button type="button" class="btn btn-info mb-3" id="CommentReplyId" onclick="toggleReplyComment({{$comment->id}})">Reply</button>
    <form action ="{{route('comments.storeReply', $comment)}}" id="replyComment-{{$comment->id}}" method="POST" class="ml-5 mb-3 d-none">
    @csrf
    <div class="form-group">
      <label for="replyComment">Your Reply</label>
      <textarea name="replyComment" id="replyComment" class="form-control @error('replyComment') is-invalid @enderror" rows="5" placeholder="" aria-describedby="helpId" required></textarea>
            @error('replyComment')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Add Reply</button>
    </form>
    @endauth
    @empty
        <div class="alert alert-info">No comments at the moment...check again later</div>
    @endforelse
    <form action ="{{route('comments.store', $topic->id)}}" method="POST" class="mt-3">
    @csrf
     <label for="content" class="form-control">{{ __('Post a comment') }}</label>
    <textarea name="content" id="content" cols="10" rows="5" class="form-control @error('content') is-invalid @enderror" required></textarea>
            @error('content')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    <button type="submit" class="btn btn-primary">Add comment</button>
    </form>


</div>

<script>
function toggleReplyComment(id){
    let element = document.getElementById('replyComment-' + id);
    element.classList.toggle('d-none');

}
// function markAsSolution(commentId, solutionId,elem) {
//     var csrfToken='{{csrf_token()}}';
//     $.post('{{route('markAsSolution')}}', {solutionId: solutionId, commentId: commentId,_token:csrfToken}, function (data) {
//     $(elem).text('Solution');
//         });
//     }

</script>

@endsection
