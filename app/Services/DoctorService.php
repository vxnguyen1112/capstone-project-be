<?php

    namespace App\Services;

    use App\Helpers\DataReturn;
    use App\Helpers\HttpCode;
    use App\Repositories\AccountRepository;
    use App\Repositories\DoctorRepository;
    use Illuminate\Support\Facades\Log;

    class DoctorService
    {
        protected $doctorRepository;
        protected $accountRepository;

        /**
         * @param $doctorRepository
         */


        public function __construct(DoctorRepository $doctorRepository, AccountRepository $accountRepository)
        {
            $this->doctorRepository = $doctorRepository;
            $this->accountRepository = $accountRepository;
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

        public function getAllDoctor()
        {
            return DataReturn::Result($this->doctorRepository->getAllDoctor());
        }

        public function getFreeTimeByDoctorId($id, $param)
        {
            if (!$this->checkDoctorIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->doctorRepository->getFreeTimeByDoctorId($id, $param));
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
