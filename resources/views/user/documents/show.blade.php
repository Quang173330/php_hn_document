@extends('user.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/show-doc.css') }}">
@endsection
@section('content')
    <nav>
        <div class="container">
            <div class="row">
                <div class="bc-icons-2">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb lighten-4">
                            <li class="breadcrumb-item">
                                <a class="text-black-50" href="">@lang('user.view-document')</a>
                                <i class="fas fa-angle-double-right mx-2" aria-hidden="true"></i>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </nav>
    <div class="container custom">
        <div class="row a">
            <div class="col-sm-9 mx-auto b">
                <h2 class="mb-5"><strong>{{ $document->name }}</strong></h2>
                <div class="mb-4">
                    @lang('user.uploaded_by')
                    <a href="{{ route('users.show', ['user' => $author->id]) }}">{{ $author->name }}</a>
                    @lang('user.on') {{ $document->created_at->format('M-d-Y') }}
                </div>
                <div class="mb-4">
                    @lang('user.category')
                    <a href="{{ route('user.category_documents', ['id' => $document->category->id]) }}">
                        {{ $document->category->name }}
                    </a>
                </div>
                <div class="mb-4 d-flex">
                    <div>
                        <strong>@lang('user.description')</strong>
                        {{ $document->description }}
                    </div>
                </div>
                <div class="d-flex mb-4">
                    <form action="{{ route('documents.download', ['id' => $document->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class=" btn btn-sm btn-info mr-4">
                            @lang('user.download') <i class="fas fa-file-download"></i>
                        </button>
                    </form>
                    @if ($author->id == Auth::id())
                        <form method="POST" action="{{ route('user.documents.destroy', ['document' => $document->id]) }}">
                            @csrf
                            @method('delete')
                            <button type="submit" class=" btn btn-sm btn-danger">
                                @lang('user.delete') <i class="far fa-trash-alt"></i>
                            </button>
                        </form>
                    @elseif (Auth::user()->favorites->contains($document))
                        <form method="POST" action="{{ route('documents.unmark', ['id' => $document->id]) }}">
                            @csrf
                            <button type="submit" class=" btn btn-sm btn-danger">
                                @lang('user.unsave')<i class="far fa-bookmark"></i>
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('documents.mark', ['id' => $document->id]) }}">
                            @csrf
                            <button type="submit" class=" btn btn-sm btn-danger">
                                @lang('user.save')<i class="far fa-bookmark"></i>
                            </button>
                        </form>
                    @endif
                </div>
                <iframe src="{{ asset($document->url) }}" scrolling="auto" frameborder="0" class="mx-auto mt-4"></iframe>
            </div>
            <div class="col-md-9 col-sm-12 mx-auto my-5">
                <div class="comment-wrapper">
                    <div class="card border-info">
                        <div class="card-header bg-info">
                            @lang('user.comment_panel')
                        </div>
                        <div class="card-body">
                            <form action="{{ route('documents.comment', ['id' => $document->id]) }}" method="POST"
                                class="mb-5">
                                @csrf
                                @error('comment')
                                    <span class="invalid-feedback d-block mt-0 mb-2" role="alert">{{ $message }}</span>
                                @enderror
                                <textarea class="form-control" name="comment" placeholder="@lang('user.comment_input')"
                                    rows="3"></textarea>
                                <br>
                                <input type="submit" class="btn btn-info float-right" value="@lang('user.post')">
                            </form>
                            <hr>
                            <ul class="media-list">
                                @foreach ($comments as $comment)
                                    <li class="media">
                                        <a href="" class="float-left mr-3">
                                            <img src="{{ $comment->image }}" alt="" class="rounded-circle">
                                        </a>
                                        <div class="media-body">
                                            <span class="text-muted float-right">
                                                <small class="text-muted mr-3">{{ $comment->pivot->created_at }}</small>
                                            </span>
                                            <strong class="text-success">{{ $comment->name }}</strong>
                                            <p>{{ $comment->pivot->content }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
