@extends('layouts.app')

@section('content')

<div class="container">
<h4>{{$topic->title}}</h4>
<hr>
<form action="{{route('topics.update', $topic->id)}}" method="POST">
@csrf

<div class="form-group row">
    <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Your topic') }}</label>

    <div class="col-md-6">
        <input id="title" type="title" class="form-control @error('title') is-invalid @enderror" name="title" value={{$topic->title}} required autocomplete="title" autofocus>

        @error('title')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="content" class="col-md-4 col-form-label text-md-right">{{ __('Your Subject') }}</label>

    <div class="col-md-6">
        <textarea id="content" type="content" rows="5" class="form-control @error('content') is-invalid @enderror" name="content" required autocomplete="content">
        {{$topic->content}}
        </textarea>
        @error('content')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<button type="submit" class="btn btn-primary">Update topic</button>
</form>

</div>

@endsection
