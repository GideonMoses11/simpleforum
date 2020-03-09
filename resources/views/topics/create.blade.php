@extends('layouts.app')

@section('extra-js')
{!! NoCaptcha::renderJs() !!}
@endsection


@section('content')

<div class="container">
<h4>Create a topic</h4>
<hr>
<form action="{{route('topics.store')}}" method="POST">
@csrf
<div class="form-group row">
    <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Your topic') }}</label>

    <div class="col-md-6">
        <input id="title" type="title" class="form-control @error('title') is-invalid @enderror" name="title" required autocomplete="title" autofocus>

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
        </textarea>
        @error('content')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
{{-- <div class="form-group">
    {!! NoCaptcha::display(['data-theme' => 'dark']) !!}
    @if ($errors->has('g-recaptcha-response'))
        <span class="help-block">
            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
        </span>
    @endif
</div> --}}
<button type="submit" class="btn btn-primary">Create topic</button>
</form>

</div>















@endsection
