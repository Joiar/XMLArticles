@extends('master')

@section('content')
    <div class="container mt-4 bg-white p-4">
        @if (session('message'))
            <div class="alert alert-danger">
                {{ session('message') }}
            </div>
        @endif
        <h2 class="text-center mb-4"><b>{{$articleDetail->title}}</b></h2>
        <div class="row border-bottom mb-2">
            <div class="col-md-9 pb-2">
                <p class="text-left mb-0">
                    <span class="col-md-3">Author:{{$articleDetail->author}}</span>
                    <span class="col-md-3">Category:{{$articleDetail->category}}</span>
                    <span class="col-md-3">Link:<a href="{{$articleDetail->link}}" target="_blank">{{$articleDetail->link}}</a></span>
                </p>
            </div>
            <div class="col-md-3 text-right">
                @if($isSelf)
                    <a class="btn btn-outline-info px-3 py-0" href='{{url("/article/edit/$articleDetail->articleID")}}' role="button">Edit</a>
                    <a class="btn btn-outline-danger px-3 py-0" href='{{url("/article/doDelete/$articleDetail->articleID")}}' role="button">Delete</a>

                @endif
            </div>
        </div>

        <p>{!! $articleDetail->body !!}</p>
    </div>
@endsection