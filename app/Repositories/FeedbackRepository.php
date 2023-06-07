<?php

    namespace App\Repositories;

    use Prettus\Repository\Contracts\RepositoryInterface;

    interface FeedbackRepository extends RepositoryInterface
    {
        public function getFeedbackByDoctor($id);
    }
