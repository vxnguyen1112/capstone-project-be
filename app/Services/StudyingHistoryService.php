<?php

    namespace App\Services;

    use App\Exceptions\FreetimeException;
    use App\Helpers\DataReturn;
    use App\Helpers\FreeTimeMessage;
    use App\Helpers\HttpCode;
    use App\Helpers\Validate;
    use App\Repositories\DoctorRepository;
    use App\Repositories\ExperienceRepository;
    use App\Repositories\MedicalRecordRepository;
    use App\Repositories\MedicationRepository;
    use App\Repositories\StudyingHistoryRepository;
    use Carbon\Carbon;

    class StudyingHistoryService
    {
        protected $studyingHistoryRepository;

        protected $doctorRepository;


        /**
         * @param $studyingHistoryRepository
         * @param $doctorRepository
         */


        public function __construct(StudyingHistoryRepository $studyingHistoryRepository, DoctorRepository $doctorRepository)
        {
            $this->studyingHistoryRepository = $studyingHistoryRepository;
            $this->doctorRepository = $doctorRepository;
        }

        public function store($data)
        {
            $result = [];
            foreach ($data['studying_histories'] as $item) {
                $item['doctor_id'] = $data['doctor_id'];
                array_push($result, $this->studyingHistoryRepository->create($item));
            }
            return DataReturn::Result($result);
        }

        public function getStudyingHistoryById($id)
        {
            if (!$this->checkStudyingHistoryIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->studyingHistoryRepository->findWhere(['id' => $id]));
        }

        public function getStudyingHistoryByDoctorId($id)
        {
            $studyingHistory = $this->doctorRepository->findWhere(['id' => $id])->first();
            if (is_null($studyingHistory)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->studyingHistoryRepository->findWhere(['doctor_id' => $id]));
        }
        public function checkStudyingHistoryIsExist($id)
        {
            return !is_null($this->studyingHistoryRepository->findWhere(['id' => $id])->first());
        }

        public function update($data, $id)
        {
            if (!$this->checkStudyingHistoryIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->studyingHistoryRepository->update($data, $id));
        }

        public function delete($id)
        {
            if (!$this->checkStudyingHistoryIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->studyingHistoryRepository->delete($id));
        }
    }
