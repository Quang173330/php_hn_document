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
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-pills nav-pills--brand m-nav-pills--align-right m-nav-pills--btn-pill m-nav-pills--btn-sm"
                            role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a href="#m_widget4_tab1_content" id="own_link" class="nav-link m-tabs__link active"
                                    data-toggle="tab" role="tab">
                                    @lang('user.own_docs')
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a href="#m_widget4_tab2_content" id="favorite_link" class="nav-link m-tabs__link"
                                    data-toggle="tab" role="tab">
                                    @lang('user.favorite_docs')
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="m_widget4_tab1_content" role="tabpanel" aria-labelledby="own_link">
                            <div id="own_documents" class="m-widget4 m-widget4--progress">
                                @foreach ($documents as $document)
                                    <div class="m-widget4__item d-flex justify-content-around">
                                        <div class="m-widget4__info">
                                            <span class="m-widget4__title">
                                                <a class="text-dark"
                                                    href="{{ route('user.documents.show', ['document' => $document->id]) }}">
                                                    {{ $document->name }}
                                                </a>
                                            </span>
                                            <br>
                                            <a class="text-dark"
                                                href="{{ route('users.show', ['user' => $document->uploadBy->id]) }}">
                                                {{ $document->uploadBy->name }}
                                            </a>
                                            <br>
                                            <br>
                                            <span>
                                                @lang('user.category')
                                                <a
                                                    href="{{ route('user.category_documents', ['id' => $document->category->id]) }}">
                                                    {{ $document->category->name }}
                                                </a>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext d-flex">
                                            <form action="{{ route('documents.download', ['id' => $document->id]) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class=" btn btn-sm btn-info mr-4">
                                                    @lang('user.download') <i class="fas fa-file-download"></i>
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
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane" id="m_widget4_tab2_content" role="tabpanel" aria-labelledby="favorite_link">
                            <div id="favorite_documents" class="m-widget4 m-widget4--progress">
                                @foreach ($favoriteDocuments as $document)
                                    <div class="m-widget4__item d-flex justify-content-around">
                                        <div class="m-widget4__info">
                                            <span class="m-widget4__title">
                                                <a class="text-dark"
                                                    href="{{ route('user.documents.show', ['document' => $document->id]) }}">
                                                    {{ $document->name }}
                                                </a>
                                            </span>
                                            <br>
                                            <a class="text-dark"
                                                href="{{ route('users.show', ['user' => $document->uploadBy->id]) }}">
                                                {{ $document->uploadBy->name }}
                                            </a>
                                            <br>
                                            <br>
                                            <span>
                                                @lang('user.category')
                                                <a
                                                    href="{{ route('user.category_documents', ['id' => $document->category->id]) }}">
                                                    {{ $document->category->name }}
                                                </a>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext d-flex">
                                            <form action="{{ route('documents.download', ['id' => $document->id]) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class=" btn btn-sm btn-info mr-4">
                                                    @lang('user.download') <i class="fas fa-file-download"></i>
                                                </button>
                                            </form>
                                            <form method="POST"
                                                action="{{ route('documents.unmark', ['id' => $document->id]) }}">
                                                @csrf
                                                <button type="submit" class=" btn btn-sm btn-warning">
                                                    @lang('user.unsave')<i class="far fa-bookmark"></i>
                                                </button>
                                            </form>
                                        </div>
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
