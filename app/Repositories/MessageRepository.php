<?php

    namespace App\Repositories;

    use Prettus\Repository\Contracts\RepositoryInterface;

    interface MessageRepository extends RepositoryInterface
    {
        public function getAllConversation($id);
        public function getMessageByIdAccount($id);
    }
