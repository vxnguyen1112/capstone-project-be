<?php

    namespace App\Services;

    use App\Helpers\DataReturn;
    use App\Helpers\HttpCode;
    use App\Repositories\AccountRepository;
    use App\Repositories\AppointmentRepository;
    use App\Repositories\DoctorRepository;
    use App\Repositories\ExperienceRepository;
    use App\Repositories\StudyingHistoryRepository;
    use Illuminate\Support\Facades\Log;

    class DoctorService
    {
        protected $doctorRepository;
        protected $accountRepository;
        protected $appointmentRepository;

        protected $experienceRepository;
        protected $studyingHistoryRepository;

        /**
         * @param $doctorRepository
         * @param $accountRepository
         * @param $appointmentRepository
         * @param $experienceRepository
         * @param $studyingHistoryRepository
         */


        public function __construct(
            DoctorRepository $doctorRepository,
            AccountRepository $accountRepository,
            AppointmentRepository $appointmentRepository,
            ExperienceRepository $experienceRepository,
            StudyingHistoryRepository $studyingHistoryRepository
        ) {
            $this->doctorRepository = $doctorRepository;
            $this->accountRepository = $accountRepository;
            $this->appointmentRepository = $appointmentRepository;
            $this->experienceRepository = $experienceRepository;
            $this->studyingHistoryRepository = $studyingHistoryRepository;
        }

        public function store($data)
        {
            $this->accountRepository->update(['is_verified' => true], $data['account_id']);
            $doctor = $this->doctorRepository->create($data);
            $doctor['experiences']=[];
            $doctor['studying_histories']=[];
            if (array_key_exists('experiences', $data)) {
                foreach ($data['experiences'] as $item) {
                    $item['doctor_id'] = $doctor['id'];
                    $temp = $doctor['experiences'];
                    array_push($temp, $this->experienceRepository->create($item));
                    $doctor['experiences'] = $temp;
                }
            }
            if (array_key_exists('studying_histories', $data)) {
                foreach ($data['studying_histories'] as $item) {
                    $item['doctor_id'] = $doctor['id'];
                    $temp = $doctor['studying_histories'];
                    array_push($temp, $this->studyingHistoryRepository->create($item));
                    $doctor['studying_histories'] = $temp;
                }
            }
            return DataReturn::Result($doctor);
        }

        public function getDoctorById($id)
        {
            if (!$this->checkDoctorIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->doctorRepository->getDoctorById($id));
        }

        public function getAllDoctor($query)
        {
            if (!key_exists('name', $query)) {
                return DataReturn::Result($this->doctorRepository->getAllDoctor());
            }
            $query = addslashes($query['name']);
            return DataReturn::Result($this->doctorRepository->getAllDoctor($query));
        }

        public function getFreeTimeByDoctorId($id, $param)
        {
            if (!$this->checkDoctorIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->doctorRepository->getFreeTimeByDoctorId($id, $param));
        }

        public function getPatientOfDoctor($id, $query)
        {
            if (!$this->checkDoctorIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            $listPatient = $this->appointmentRepository->getIdPatientOfDoctor($id)->toArray();
            if (!count($listPatient)) {
                return DataReturn::Result([]);
            }
            $listPatient = array_map(function ($item) {
                return $item['patient_id'];
            }, $listPatient);
            if (!key_exists('name', $query)) {
                return DataReturn::Result($this->accountRepository->getAccountByArray(array_values(array_unique($listPatient))));
            }
            $query = addslashes($query['name']);
            return DataReturn::Result($this->accountRepository->getAccountByArray(array_values(array_unique($listPatient)),
                $query));

        }

        public function getFreeTimeAllDoctor($param)
        {
            return DataReturn::Result($this->doctorRepository->getFreeTimeAllDoctor($param));
        }

        public function checkDoctorIsExist($id)
        {
            return !is_null($this->doctorRepository->findWhere(['id' => $id])->first());
        }

        public function update($data, $id)
        {
            if (!$this->checkDoctorIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->doctorRepository->update($data, $id));
        }

        public function delete($id)
        {
            if (!$this->checkDoctorIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->doctorRepository->delete($id));
        }
    }
