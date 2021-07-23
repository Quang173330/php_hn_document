@extends('user.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/user-profile.css') }}">
@endsection

@section('content')
    <nav>
        <div class="container">
            <div class="row">
                <div class="bc-icons-2">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb lighten-4">
                            <li class="breadcrumb-item">
                                <a class="text-black-50" href="">@lang('home.profile')</a>
                                <i class="fas fa-angle-double-right mx-2" aria-hidden="true"></i>
                                <a class="text-black-50" href="">@lang('home.view_profile')</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </nav>
    <div class="container custom">
        <div class="row gutters">
            <div class="col-1"></div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="account-settings">
                            <div class="user-profile">
                                <div class="user-avatar">
                                    <img id="avatar" src={{ $user->image }}>
                                    <input id="upload-avatar" type="file" class="d-none">
                                </div>
                                <h5 class="user-name">{{ $user->name }}</h5>
                                <h6 class="user-email">{{ $user->email }}</h6>
                            </div>
                            <div class="about">
                                <h5>@lang('user.about')</h5>
                                <p>{{ $user->about }}</p>
                            </div>
                            @if (!$check)
                                <div class="d-flex justify-content-around">
                                    @if ($follow)
                                        <form action={{ route('unfollow', ['id' => $user->id]) }} method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-primary">@lang('user.unfollow_button')</button>
                                        </form>
                                    @else
                                        <form action={{ route('follow', ['id' => $user->id]) }} method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-primary">@lang('user.follow_button')</button>
                                        </form>
                                    @endif
                                    <button class="btn btn-outline-primary">@lang('user.message_button')</button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">@lang('user.name')</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">{{ $user->name }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">@lang('user.email')</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">{{ $user->email }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">@lang('user.phone')</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">{{ $user->phone }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">@lang('user.address')</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">{{ $user->address }}</div>
                        </div>
                        <hr>
                        @if ($check)
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">@lang('user.download_free')</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">{{ $user->download_free }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">@lang('user.upload')</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">{{ $user->upload }}</div>
                            </div>
                            <hr>
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="text-right">
                                        <a type="button" id="submit" name="submit" class="btn btn-primary"
                                            href={{ route('users.edit', ['user' => $user->id]) }}>
                                            @lang('user.edit')
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
