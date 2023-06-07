<?php

    namespace App\Services;

    use App\Helpers\DataReturn;
    use App\Helpers\HttpCode;
    use App\Repositories\AccountRepository;
    use App\Repositories\AppointmentRepository;
    use App\Repositories\DoctorRepository;
    use Illuminate\Support\Facades\Log;

    class DoctorService
    {
        protected $doctorRepository;
        protected $accountRepository;
        protected $appointmentRepository;

        /**
         * @param $doctorRepository
         * @param $accountRepository
         * @param $appointmentRepository
         */


        public function __construct(
            DoctorRepository $doctorRepository,
            AccountRepository $accountRepository,
            AppointmentRepository $appointmentRepository
        ) {
            $this->doctorRepository = $doctorRepository;
            $this->accountRepository = $accountRepository;
            $this->appointmentRepository = $appointmentRepository;
        }

        public function store($data)
        {
            $this->accountRepository->update(['is_verified' => true], $data['account_id']);
            return DataReturn::Result($this->doctorRepository->create($data));
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
