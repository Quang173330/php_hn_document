@extends('user.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/upload.css') }}">
@endsection

@section('content')
    <nav>
        <div class="container">
            <div class="row">
                <div class="bc-icons-2">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb lighten-4">
                            <li class="breadcrumb-item">
                                <a class="text-black-50" href="">@lang('uploads.upload')</a>
                                <i class="fas fa-angle-double-right mx-2" aria-hidden="true"></i>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </nav>
    <div class="container">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        <form action={{ route('user.documents.storeUpload') }} method="POST" enctype="multipart/form-data">
            @method('post')
            @csrf
            <div class="row it">
                <div class="col-sm-offset-1 col-sm-10 m-auto" id="one">
                    <div class="row">
                        <div class="col-sm-offset-4 col-sm-4 form-group">
                            <h3 class="text-center">@lang('uploads.header')</h3>
                        </div>
                    </div>
                    <div id="uploader">
                        <div class="row uploadDoc">
                            <div class="col-sm-4">
                                <div class="docErr">@lang('uploads.invalid')</div>
                                @error('file')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="fileUpload btn btn-orange">
                                    <img src="{{ asset('images/web/file.svg') }}" class="icon">
                                    <span class="upl" id="upload">@lang('uploads.document')</span>
                                    <input name="file" type="file" class="upload up" id="up" required>
                                </div>
                                <p>
                                    @lang('uploads.supported')
                                </p>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('uploads.category'):</label>
                                    <select class="form-control" name="category" id="category">
                                        <option value="">@lang('uploads.select_category')</option>
                                        @include('user.documents.category_options', ['level' => 0])
                                    </select>
                                </div>
                                <div class="form-group">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <label for="inputUsername">@lang('uploads.title')( @lang('uploads.required'))</label>
                                    <input name="name" type="text" class="form-control" id="inputUsername"
                                        placeholder="@lang('uploads.title')" required>
                                </div>
                                <div class="form-group">
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <label for="inputUsername">@lang('uploads.description')(
                                        @lang('uploads.required'))</label>
                                    <textarea name="description" rows="2" class="form-control" id="inputBio"
                                        placeholder="@lang('uploads.description')" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-next" type="submit"><i class="fa fa-paper-plane"></i>
                            @lang('uploads.done')</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('js/upload.js') }}"></script>
@endpush
