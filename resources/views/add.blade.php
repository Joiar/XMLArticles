@extends('master')

{{--@section('style')--}}
    {{--<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">--}}
    {{--<style>--}}
        {{--.hidden {--}}
            {{--display: none;--}}
        {{--}--}}
    {{--</style>--}}
{{--@endsection--}}

@section('content')
    <div class="container mt-4 bg-white p-4">
        @if (session('message'))
            <div class="alert alert-danger">
                {{ session('message') }}
            </div>
        @endif
        <form action="{{url('/article/doAdd')}}" method="post">
            <h3 class="border-bottom mb-4">Add article</h3>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" id="title" placeholder="Enter title" required value="{{ old('title') }}">
                @if ($errors->has('title'))
                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="link">Link</label>
                <input type="url" class="form-control {{ $errors->has('link') ? ' is-invalid' : '' }}" name="link" id="link" placeholder="Enter link" required  value="{{ old('link') }}">
                @if ($errors->has('link'))
                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('link') }}</strong>
                                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select class="form-control {{ $errors->has('category') ? ' is-invalid' : '' }}" id="category" name="category" required>
                    @foreach($categoryList as $catehory)
                        <option value="{{$catehory}}" {{ old('category') == $catehory ? 'selected' : '' }}>{{$catehory}}</option>
                    @endforeach
                </select>
                @if ($errors->has('category'))
                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('category') }}</strong>
                                    </span>
                @endif
            </div>
            <div class="form-group  {{ $errors->has('body') ? ' is-invalid' : '' }}">
                <label for="body">Body</label>
                <textarea class="form-control" name="body" id="body" rows="4">{{ old('body') }}</textarea>
            </div>
            @if ($errors->has('body'))
                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
            @endif
            {{csrf_field()}}
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection

{{--@section('script')--}}
    {{--<script src="https://cdn.ckeditor.com/4.9.1/standard/ckeditor.js"></script>--}}
    {{--<script>--}}
        {{--$(function () {--}}
            {{--CKEDITOR.replace( 'body' );--}}
        {{--});--}}
    {{--</script>--}}
{{--@endsection--}}