<?php

    namespace App\Repositories;


    use Prettus\Repository\Contracts\RepositoryInterface;

    interface DoctorRepository extends RepositoryInterface
    {
        public function getDoctorById($id);
    }
