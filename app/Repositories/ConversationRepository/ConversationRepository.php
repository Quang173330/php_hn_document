<?php

namespace App\Repositories\ConversationRepository;

use App\Repositories\BaseRepository;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;

class ConversationRepository extends BaseRepository implements ConversationRepositoryInterface
{
    public function getModel()
    {
        return Conversation::class;
    }

    public function getConversation($userId, $partnerId)
    {
        return $this->model->where([['user_id', $userId], ['partner_id', $partnerId]])
            ->orWhere([['user_id', $partnerId], ['partner_id', $userId]])->first();
    }

    public function getListConversation($userId)
    {
        return $this->model->where([['user_id', $userId]])
        ->orWhere([['partner_id', $userId]])->orderBy('updated_at', 'desc')->with(['messages', 'user', 'partner'])->get();
    }

    public function updateRead($conversation)
    {
        return $conversation->messages()->where([['is_read', 1], ['receiver_id', Auth::id()]])->update(['is_read' => 0]);
    }
}
