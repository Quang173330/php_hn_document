@extends('user.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/list-docs.css') }}">
@endsection

@section('content')
    <nav>
        <div class="container">
            <div class="row">
                <div class="bc-icons-2">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb lighten-4">
                            <li class="breadcrumb-item">
                                <a class="text-black-50" href="">@lang('user.list_docs')</a>
                                <i class="fas fa-angle-double-right mx-2" aria-hidden="true"></i>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </nav>
    <div class="container custom">
        <div class="col-md-12">
            <div class="m-portlet m-portlet--full-height ">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                @lang('user.list_docs')
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="m_widget4_tab1_content">
                            <div class="m-widget4 m-widget4--progress">
                                @foreach ($documents as $document)
                                    <div class="m-widget4__item d-flex justify-content-around">
                                        <div class="m-widget4__info">
                                            <span class="m-widget4__title">
                                                {{ $document->name }}
                                            </span>
                                            <br>
                                            <span class="m-widget4__sub">
                                                {{ Auth::user()->name }}
                                            </span>
                                        </div>
                                        @if ($document->user_id == Auth::id())
                                            <div class="m-widget4__ext d-flex">
                                                <form method="GET" action="{{ route('users.edit', ['user' => '1']) }}">
                                                    <button type="submit" class=" btn btn-sm btn-warning mr-4">
                                                        @lang('user.edit') <i class="fas fa-pencil-alt"></i>
                                                    </button>
                                                </form>
                                                <form method="POST"
                                                    action="{{ route('user.documents.destroy', ['document' => $document->id]) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class=" btn btn-sm btn-danger">
                                                        @lang('user.delete') <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <div class="m-widget4__ext d-flex">
                                                <form action="">
                                                    <button class=" btn btn-sm btn-warning mr-4">
                                                        <a href="{{ asset('uploads\pdf\\' . $document->url) }}"
                                                            download="{{ $document->name }}">
                                                            @lang('user.download') <i class="fas fa-file-download"></i>
                                                        </a>
                                                    </button>
                                                </form>
                                                @if (Auth::user()->favorites->contains($document))
                                                    <form method="POST"
                                                        action="{{ route('documents.unmark', ['id' => $document->id]) }}">
                                                        @csrf
                                                        <button type="submit" class=" btn btn-sm btn-danger">
                                                            @lang('user.unsave')<i class="far fa-bookmark"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form method="POST"
                                                        action="{{ route('documents.mark', ['id' => $document->id]) }}">
                                                        @csrf
                                                        <button type="submit" class=" btn btn-sm btn-danger">
                                                            @lang('user.save')<i class="far fa-bookmark"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        @endif

                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
