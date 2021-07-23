<header class="header">
    <div class="header_main">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-sm-3 col-3 order-1">
                    <div class="logo_container">
                        <div class="logo"><a href="{{ route('home') }}">{{ config('web.logo') }}</a></div>
                    </div>
                </div>
                <div class="col-lg-6 col-12 order-lg-2 order-3 text-lg-left text-right">
                    <div class="header_search">
                        <div class="header_search_content">
                            <div class="header_search_form_container">
                                <form action="{{ route('documents.search') }}" method="POST"
                                    class="header_search_form clearfix">
                                    @csrf
                                    <input type="search" name="name" required="required" class="header_search_input"
                                        placeholder="@lang('home.search')">
                                    <div class="custom_dropdown">
                                        <div class="custom_dropdown_list">
                                            <span
                                                class="custom_dropdown_placeholder clc">@lang('home.categories')</span><i
                                                class="fas fa-chevron-down"></i>
                                            <ul class="custom_list clc">
                                                <li><a class="clc" href="">@lang('home.categories')</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <button type="submit" class="header_search_button trans_300" value="Submit">
                                        <i class="text-white fas fa-search"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-9 order-lg-3 order-2 text-lg-left text-right">
                    <div class="wishlist_cart d-flex flex-row align-items-center justify-content-end">
                        <div class="top_bar_menu">
                            <ul class="standard_dropdown top_bar_dropdown">
                                <li>
                                    <a href="">
                                        @if (App::isLocale(Config::get('user.en')))
                                            @lang('home.en')
                                        @else
                                            @lang('home.vi')
                                        @endif
                                        <i class="fas fa-chevron-down"></i>
                                    </a>
                                    <ul>
                                        @if (App::isLocale(Config::get('user.en')))
                                            <li>
                                                <a
                                                    href="{{ route('change-language', ['locale' => Config::get('user.vi')]) }}">
                                                    @lang('home.vi')
                                                </a>
                                            </li>
                                        @else
                                            <li>
                                                <a
                                                    href="{{ route('change-language', ['locale' => Config::get('user.en')]) }}">
                                                    @lang('home.en')
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="top_bar_content ml-auto">
                            <div class="wishlist_content">
                                <div class="wishlist_text">
                                    <a href="{{ route('user.documents.storeUpload') }}">
                                        <i class="fas fa-upload"></i>@lang('home.upload')
                                    </a>
                                </div>
                            </div>
                        </div>
                        @if (!Auth::check())
                            <div class="top_bar_content ml-auto">
                                <div class="wishlist_content">
                                    <div class="wishlist_text">
                                        <a href="{{ route('register') }}">@lang('home.register')</a>
                                    </div>
                                </div>
                            </div>
                            <div class="top_bar_content ml-auto">
                                <div class="wishlist_content">
                                    <div class="wishlist_text">
                                        <a href="{{ route('login') }}">@lang('home.sign_in')</a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="top_bar_content ml-auto">
                                <div class="wishlist_content">
                                    <ul class="standard_dropdown top_bar_dropdown">
                                        <li>
                                            <a href="">@lang('home.profile')<i class="fas fa-chevron-down"></i></a>
                                            <ul>
                                                <li>
                                                    <a
                                                        href="{{ route('users.show', ['user' => Auth::user()->id]) }}">@lang('home.view_profile')</a>
                                                </li>
                                                <li>
                                                    <a
                                                        href="{{ route('users.edit', ['user' => Auth::user()->id]) }}">@lang('home.edit_profile')</a>
                                                </li>
                                                <li>
                                                    <a
                                                        href="{{ route('user.documents.index') }}">@lang('home.list_documents')</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="top_bar_content ml-auto">
                                <div class="wishlist_content">
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <input id="logout-input" class="btn mt-10" type="submit"
                                            value=@lang('home.logout')>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
