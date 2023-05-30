<?php

    namespace App\Repositories;


    use Prettus\Repository\Contracts\RepositoryInterface;

    interface AccountRepository extends RepositoryInterface
    {
        public function getAppointmentAllPatient($param);

        public function getAppointmentByPatientId($id, $param);

    }
