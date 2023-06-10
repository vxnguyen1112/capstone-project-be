<?php

    namespace App\Services;


    use App\Repositories\NotificationRepository;

    class NotificationService
    {
        protected $notificationRepository;

        /**
         * @param $notificationRepository
         */
        public function __construct(NotificationRepository $notificationRepository)
        {
            $this->notificationRepository = $notificationRepository;
        }

        public function store($data)
        {
            return $this->notificationRepository->create($data);
        }

        public function getNotification()
        {
            return $this->notificationRepository->getNotification();
        }

        public function checkNotification()
        {
            $check = $this->notificationRepository->checkNotification();
            return ["check" => $check];
        }

    }
