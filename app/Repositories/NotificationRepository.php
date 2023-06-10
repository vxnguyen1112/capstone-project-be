<?php

    namespace App\Repositories;

    use Prettus\Repository\Contracts\RepositoryInterface;

    interface NotificationRepository extends RepositoryInterface
    {
        public function getNotification();

        public function checkNotification();
    }
