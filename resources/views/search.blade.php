@extends('master')

@section('style')
    <style>
        .detail-link {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="col-md-12 pt-4">
            <div class="text-right mb-2">
                <a class="btn btn-outline-success" href="{{url('/article/add')}}" role="button">Add article</a>
            </div>
            <ul class="list-group">
                @forelse ($articleList as $article)
                    <li class="list-group-item list-group-item-action mb-2 mt-0 detail-link"
                        data-url='{{url("detail/$article->articleID")}}'>
                        <div class="d-flex justify-content-between align-items-center">
                            <h5>{{$article->title}}</h5>
                            <span>{{$article->category}}</span>
                        </div>
                        <div>
                            {!! $article->body !!}
                        </div>
                    </li>
                @empty
                    <li class="list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                        <span>No Articles</span>
                    </li>
                @endforelse
            </ul>
            <nav aria-label="Page navigation">
                {{ $articleList->links() }}
            </nav>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('.detail-link').click(function () {
            var url = $(this).attr('data-url');
            location.href = url;
        });

        var keywords = "{{$keywords}}";
        console.log(keywords);
        $('#keywords').val(keywords);
    </script>
@endsection