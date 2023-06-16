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
    use Carbon\Carbon;

    class ExperienceService
    {
        protected $experienceRepository;

        protected $doctorRepository;


        /**
         * @param $experienceRepository
         */


        public function __construct(ExperienceRepository $experienceRepository, DoctorRepository $doctorRepository)
        {
            $this->experienceRepository = $experienceRepository;
            $this->doctorRepository = $doctorRepository;
        }

        public function store($data)
        {
            $result = [];
            foreach ($data['experiences'] as $item) {
                $item['doctor_id'] = $data['doctor_id'];
                array_push($result, $this->experienceRepository->create($item));
            }
            return DataReturn::Result($result);
        }

        public function getExperienceById($id)
        {
            if (!$this->checkExperienceIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->experienceRepository->findWhere(['id' => $id]));
        }

        public function getExperienceByDoctorId($id)
        {
            $experience = $this->doctorRepository->findWhere(['id' => $id])->first();
            if (is_null($experience)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->experienceRepository->findWhere(['doctor_id' => $id]));
        }
        public function checkExperienceIsExist($id)
        {
            return !is_null($this->experienceRepository->findWhere(['id' => $id])->first());
        }

        public function update($data, $id)
        {
            if (!$this->checkExperienceIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->experienceRepository->update($data, $id));
        }

        public function delete($id)
        {
            if (!$this->checkExperienceIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->experienceRepository->delete($id));
        }
    }
