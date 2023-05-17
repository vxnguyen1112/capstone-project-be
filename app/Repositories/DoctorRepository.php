<?php

    namespace App\Repositories;


    use Prettus\Repository\Contracts\RepositoryInterface;

    interface DoctorRepository extends RepositoryInterface
    {
        public function getDoctorById($id);

        public function getAllDoctor();

        public function getFreeTimeAllDoctor($param);

        public function getFreeTimeByDoctorId($id, $param);

        public function getAppointmentAllDoctor($param);

        public function getAppointmentByDoctorId($id, $param);

    }
