<?php
namespace App\Repositories\ConversationRepository;

use App\Repositories\RepositoryInterface;

interface ConversationRepositoryInterface extends RepositoryInterface
{
    public function getConversation($userId, $partnerId);

    public function getListConversation($userId);

    public function updateRead($conversation);
}