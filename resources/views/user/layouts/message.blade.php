<div class="py-2 px-4 border-bottom d-none d-lg-block">
    <div class="d-flex align-items-center py-1">
        <div class="position-relative">
            <img src="{{ asset($receiver->image) }}" class="rounded-circle mr-1" alt="Sharon Lessman" width="40"
                height="40">
        </div>
        <div class="flex-grow-1 pl-3">
            <strong>{{ $receiver->name }}</strong>
            <div class="small"><span class="fas fa-circle chat-online"></span> Online</div>
        </div>
    </div>
</div>
<div class="position-relative">
    <div id="chat-messages" class="chat-messages p-4">
        @foreach ($messages as $message)
            @if ($message->user_id == Auth::id())
                <div class="chat-message-right pb-4">
                    <div>
                        <div class="text-muted small text-nowrap mt-2">
                            {{ $message->updated_at->format('H:i:s') }}</div>
                    </div>
                    <div class="flex-shrink-1 rounded-pill py-2 px-3 mr-3 bg-primary text-white">
                        {{ $message->content }}
                    </div>
                </div>
            @else
                <div class="chat-message-left pb-4">
                    <div>
                        <div class="text-muted small text-nowrap mt-2">2:34 am</div>
                    </div>
                    <div class="flex-shrink-1 bg-light rounded-pill py-2 px-3 ml-3">
                        {{ $message->content }}
                    </div>
                </div>
            @endif
        @endforeach

    </div>
</div>
<div class="flex-grow-0 py-3 px-4 border-top">
    <div class="input-group">
        <form id="form" action="{{ route('user.send') }}" method="post" class="d-flex">
            @csrf
            <input type="hidden" id="user" value="{{ Auth::id() }}">
            <input id="message" name="message" type="text" class="form-control" placeholder="Type your message"
                data-id="{{ $receiver->id }}">
            <button id="submit" class="btn bg-white text-primary ml-3">
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>
