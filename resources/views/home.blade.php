@extends('master')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        You are logged in!
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <ul class="list-group">
                    @forelse ($articleList as $article)
                        <li class="list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                            <a href="">{{$article->title}}</a>
                            <span class="badge badge-primary badge-pill">14</span>
                        </li>
                    @empty
                        <p>No articles</p>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection