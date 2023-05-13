<?php

    namespace App\Repositories;

    use Prettus\Repository\Contracts\RepositoryInterface;

    interface FreeTimeRepository extends RepositoryInterface
    {
        public function storeFreeTime($data);

    }
