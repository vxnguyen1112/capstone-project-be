<?php

    namespace App\Repositories;


    use Prettus\Repository\Contracts\RepositoryInterface;

    interface AppointmentRepository extends RepositoryInterface
    {
        public function checkAppointment($data,$freeTime);
        public function getIdPatientOfDoctor($id);

    }
