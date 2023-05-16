<?php

    namespace App\Services;

    use App\Helpers\DataReturn;
    use App\Helpers\HttpCode;
    use App\Models\Medical_record;
    use App\Repositories\MedicalRecordRepository;
    use App\Repositories\RoleRepository;

    class MedicalRecordService
    {
        protected $medicalRecordRepository;


        /**
         * @param $medicalRecordRepository
         */


        public function __construct(MedicalRecordRepository $medicalRecordRepository)
        {
            $this->medicalRecordRepository = $medicalRecordRepository;
        }

        public function store($data)
        {
            return DataReturn::Result($this->medicalRecordRepository->create($data));
        }

        public function getMedicalRecordById($id)
        {
            if (!$this->checkMedicalRecordIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->medicalRecordRepository->with([
                'patient',
                'doctor'
            ])->findWhere(['id' => $id]));
        }

        public function getMedicalRecordByPatientId($id)
        {
            $patient = $this->medicalRecordRepository->findWhere(['patient_id' => $id])->first();
            if (is_null($patient)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->medicalRecordRepository->getMedicalRecordByPatientId($id));
        }

        public function getMedicalRecordByDoctorId($id)
        {
            $doctor = $this->medicalRecordRepository->findWhere(['doctor_id' => $id])->first();
            if (is_null($doctor)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->medicalRecordRepository->getMedicalRecordByDoctorId($id));
        }

        public function checkMedicalRecordIsExist($id)
        {
            return !is_null($this->medicalRecordRepository->findWhere(['id' => $id])->first());
        }

        public function update($data, $id)
        {
            if (!$this->checkMedicalRecordIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->medicalRecordRepository->update($data, $id));
        }

        public function delete($id)
        {
            if (!$this->checkMedicalRecordIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->medicalRecordRepository->delete($id));
        }
    }
