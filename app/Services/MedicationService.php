<?php

    namespace App\Services;

    use App\Helpers\DataReturn;
    use App\Helpers\HttpCode;
    use App\Repositories\MedicalRecordRepository;
    use App\Repositories\MedicationRepository;

    class MedicationService
    {
        protected $medicationRepository;
        protected $medicalRecordRepository;


        /**
         * @param $medicationRepository
         * @param $medicalRecordRepository
         */


        public function __construct(
            MedicationRepository $medicationRepository,
            MedicalRecordRepository $medicalRecordRepository
        ) {
            $this->medicationRepository = $medicationRepository;
            $this->medicalRecordRepository = $medicalRecordRepository;
        }

        public function store($data)
        {
            return DataReturn::Result($this->medicationRepository->create($data));
        }

        public function getMedicationById($id)
        {
            if (!$this->checkMedicationIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->medicationRepository->findWhere(['id' => $id]));
        }

        public function getMedicationByMedicalRecordId($id)
        {
            $medicalRecord = $this->medicalRecordRepository->findWhere(['id' => $id])->first();
            if (is_null($medicalRecord)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->medicationRepository->findWhere(['medical_record_id' => $id]));
        }

        public function checkMedicationIsExist($id)
        {
            return !is_null($this->medicationRepository->findWhere(['id' => $id])->first());
        }

        public function update($data, $id)
        {
            if (!$this->checkMedicationIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->medicationRepository->update($data, $id));
        }

        public function delete($id)
        {
            if (!$this->checkMedicationIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->medicationRepository->delete($id));
        }
    }
