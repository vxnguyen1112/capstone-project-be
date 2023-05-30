<?php

    namespace App\Repositories;


    use Prettus\Repository\Contracts\RepositoryInterface;

    interface MedicalRecordRepository extends RepositoryInterface
    {
        public function getMedicalRecordByDoctorId($id);
        public function getMedicalRecordByPatientId($id);

    }
