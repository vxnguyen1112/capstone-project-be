<?php

    namespace App\Services;

    use App\Helpers\DataReturn;
    use App\Helpers\HttpCode;
    use App\Models\Medical_record;
    use App\Repositories\MedicalRecordRepository;
    use App\Repositories\MedicationRepository;
    use App\Repositories\RoleRepository;
    use Illuminate\Support\Facades\Log;

    class MedicalRecordService
    {
        protected $medicalRecordRepository;
        protected $medicationRepository;

        /**
         * @param $medicalRecordRepository
         * @param $medicationRepository
         */


        public function __construct(
            MedicalRecordRepository $medicalRecordRepository,
            MedicationRepository $medicationRepository
        ) {
            $this->medicalRecordRepository = $medicalRecordRepository;
            $this->medicationRepository = $medicationRepository;
        }

        public function store($data)
        {
            $medicalRecord = $this->medicalRecordRepository->create($data);
            $medicalRecord['medications'] = [];
            if (!array_key_exists('medications', $data)) {
                return DataReturn::Result($medicalRecord);
            }
            foreach ($data['medications'] as $item) {
                $item['medical_record_id'] = $medicalRecord['id'];
                $temp = $medicalRecord['medications'];
                array_push($temp, $this->medicationRepository->create($item));
                $medicalRecord['medications'] = $temp;
            }
            return DataReturn::Result($medicalRecord);
        }

        public function getMedicalRecordById($id)
        {
            if (!$this->checkMedicalRecordIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->medicalRecordRepository->with([
                'patient',
                'doctor',
                'medications'
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
