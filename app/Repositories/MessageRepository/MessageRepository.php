<?php

namespace App\Repositories\MessageRepository;

use App\Repositories\BaseRepository;
use App\Models\Message;

class MessageRepository extends BaseRepository implements MessageRepositoryInterface
{
    public function getModel()
    {
        return Message::class;
    }

    public function getMessageBetweenUser($userId, $receiverId)
    {
        return $this->model->where([['user_id', $userId], ['receiver_id', $receiverId]])
            ->orWhere([['user_id', $receiverId], ['receiver_id', $userId]])->get();
    }
}
