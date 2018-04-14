@extends('master')

@section('style')
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
    <style>
        .hidden {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-4 bg-white p-4">
        <form action="{{url('/article/doAdd')}}" method="post">
            <h3 class="border-bottom mb-4">Add article</h3>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" required>
            </div>
            <div class="form-group">
                <label for="link">Link</label>
                <input type="url" class="form-control" name="link" id="link" placeholder="Enter link" required>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select class="form-control" id="category" name="category" required>
                    @foreach($categoryList as $catehory)
                        <option value="{{$catehory}}">{{$catehory}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="body">Body</label>
                <textarea class="hidden" name="body" id="body"></textarea>
            </div>
            {{csrf_field()}}
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection

@section('script')
    <script src="https://cdn.ckeditor.com/4.9.1/standard/ckeditor.js"></script>
    <script>
        $(function () {
            CKEDITOR.replace( 'body' );
        });
    </script>
@endsection