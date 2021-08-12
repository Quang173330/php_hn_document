<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\MessageRepository\MessageRepositoryInterface;
use App\Repositories\ConversationRepository\ConversationRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class MessageController extends Controller
{
    protected $messageRepo;
    protected $cateRepo;
    protected $conversationRepo;
    protected $userRepo;

    public function __construct(
        MessageRepositoryInterface $messageRepo,
        CategoryRepositoryInterface $cateRepo,
        ConversationRepositoryInterface $conversationRepo,
        UserRepositoryInterface $userRepo
    ) {
        $this->cateRepo = $cateRepo;
        $this->messageRepo = $messageRepo;
        $this->conversationRepo = $conversationRepo;
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        $categories = $this->cateRepo->getCategoriesRoot();
        $user = User::find(1);
        $messages = $this->messageRepo->getMessageBetweenUser(Auth::id(), $user->id);
        return view('user.chat', compact('categories', 'users', 'messages'));
    }

    public function getMessages($id)
    {
        $categories = $this->cateRepo->getCategoriesRoot();
        $list_conversation = $this->conversationRepo->getListConversation(Auth::id());
        foreach ($list_conversation as $conversation) {
            $conversation->message = $conversation->messages->sortByDesc('updated_at')->first();
            $conversation->is_read = $conversation->message->is_read;
            $conversation->user = $conversation->user_id === Auth::id() ? $conversation->partner : $conversation->user;
        }
        $receiver = $this->userRepo->find($id);
        $conversation = $this->conversationRepo->getConversation(Auth::id(), $id);
        if (!$conversation) {
            $messages = [];

            return view('user.chat', compact('categories', 'list_conversation', 'messages', 'receiver'));
        }
        $this->conversationRepo->updateRead($conversation);
        $messages = $conversation->messages;

        return view('user.chat', compact('categories', 'list_conversation', 'messages', 'receiver'));
    }

    public function sendMessage(Request $request)
    {
        $user_id = Auth::id();
        $receiver_id = $request->receiver_id;
        $receiver = $this->userRepo->find($receiver_id);
        $message = $request->message;
        $conversation = $this->conversationRepo->getConversation($user_id, $receiver_id);
        if (!$conversation) {
            $conversation = $this->conversationRepo->create([
                'user_id' => $user_id,
                'partner_id' => $receiver_id,
            ]);
        }
        $newMessage = $this->messageRepo->create([
            'user_id' => $user_id,
            'receiver_id' => $receiver_id,
            'content' => $message,
            'conversation_id' => $conversation->id,
            'is_read' => 1
        ]);
        $this->conversationRepo->update($conversation->id, [
            'last_message' => $newMessage->id
        ]);
        $messages = $this->messageRepo->getMessageBetweenUser(Auth::id(), $receiver_id);
        $data = [
            'user_id' => $user_id,
            'receiver_id' => $receiver_id,
            'content' => $message,
            'created_at' => date('d M y, h:i a', strtotime($newMessage->created_at)),
        ];
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $pusher = new Pusher(
            '516823b5cee1080ab667',
            '22820f153969478dd15e',
            '1247827',
            $options
        );
        $pusher->trigger('MessageEvent', 'chat.' . $receiver_id, $data);

        return view('user.layouts.message', compact('messages', 'receiver'));
    }

    public function getListConversation()
    {
        $list_conversation = $this->conversationRepo->getListConversation(Auth::id());
        foreach ($list_conversation as $conversation) {
            $conversation->message = $conversation->messages->sortByDesc('updated_at')->first();
            $conversation->is_read = $conversation->message->is_read;
            $conversation->user = $conversation->user_id === Auth::id() ? $conversation->partner : $conversation->user;
        }

        return view('user.layouts.conversation', compact('list_conversation'));
    }

    public function getConversation($id)
    {
        $conversation = $this->conversationRepo->find($id);
        $this->conversationRepo->updateRead($conversation);
        $messages = $conversation->messages;
        $receiver = $conversation->user_id === Auth::id() ? $conversation->partner : $conversation->user;
        
        return view('user.layouts.message', compact('messages', 'receiver'));
    }
}
