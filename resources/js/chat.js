let user_id = $('#user').val();
$(document).ready(function () {
    $(document).on('submit', '#form', function (e) {
        e.preventDefault();
        let message = $('#message').val();
        let receiver_id = $('#message').data("id");
        let data = {
            receiver_id: receiver_id,
            message: message,
        };
        let url = $('#form').attr('action');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: "POST",
            url: url,
            data: data,
            cache: false,
            success: function (data) {
                $('#messages').html(data)
                scrollToBottom()
                $('#message').val("");
            },
            error: function (jgXHR, status, err) {
                alert(err);
            },
        })
    });

    Pusher.logToConsole = true;

    var pusher = new Pusher('516823b5cee1080ab667', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('MessageEvent');
    channel.bind(`chat.${user_id}`, function (data) {
        let receiver_id = $('#message').data("id");
        console.log(data.user_id, receiver_id)
        if (data.user_id === receiver_id) {
            let html = `<div class="chat-message-left pb-4"><div><div class="text-muted small text-nowrap mt-2">2:34 am</div></div><div class="flex-shrink-1 bg-light rounded-pill py-2 px-3 ml-3">` + data.content + `</div></div>`
            $('#chat-messages').append(html);
            scrollToBottom()
        } else {
            let url = $('#list-conversation').data("url");
            $.ajax({
                type: "GET",
                url: url,
                cache: false,
                success: function (data) {
                    $('#list-conversation').html(data)
                },
                error: function (jgXHR, status, err) {
                    alert(err);
                },
            })
        }
    });
    scrollToBottom();
    function scrollToBottom() {
        $('.chat-messages').animate({
            scrollTop: $('.chat-messages').get(0).scrollHeight
        }, 0);
    }

    $(document).on('click', '.conversation', function () {
        let url = $(this).data("url");
        $.ajax({
            type: "GET",
            url: url,
            cache: false,
            success: function (data) {
                $('#messages').html(data)
            },
            error: function (jgXHR, status, err) {
                alert(err);
            },
        })
    })
});

