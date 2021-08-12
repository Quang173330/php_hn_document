@extends('user.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
@endsection

@section('content')
    <main class="content">
        <div class="container p-0">
            <div class="card col-10 m-auto">
                <div class="row g-0">
                    <div id="list-conversation" data-url="{{ route('user.conversations') }}"
                        class="col-12 col-lg-5 col-xl-4 border-right list-friends">
                        @include('user.layouts.conversation')
                    </div>
                    <div id="messages" class="col-12 col-lg-7 col-xl-8">
                        @include('user.layouts.message')
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('js')
    <script src="{{ asset('js/chat.js') }}"></script>
@endsection
