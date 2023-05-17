<?php

    namespace App\Services;

    use App\Helpers\AppointmentStatus;
    use App\Helpers\DataReturn;
    use App\Helpers\HttpCode;
    use App\Repositories\AccountRepository;
    use App\Repositories\AppointmentRepository;
    use App\Repositories\DoctorRepository;
    use App\Repositories\FreeTimeRepository;
    use App\Repositories\RoleRepository;
    use Illuminate\Support\Facades\Log;

    class AppointmentService
    {
        protected $appointmentRepository;
        protected $doctorRepository;
        protected $accountRepository;
        protected $freeTimeRepository;


        /**
         * @param $appointmentRepository
         */


        public function __construct(
            AppointmentRepository $appointmentRepository,
            DoctorRepository $doctorRepository,
            AccountRepository $accountRepository,
            FreeTimeRepository $freeTimeRepository
        ) {
            $this->appointmentRepository = $appointmentRepository;
            $this->doctorRepository = $doctorRepository;
            $this->accountRepository = $accountRepository;
            $this->freeTimeRepository = $freeTimeRepository;
        }

        public function store($data)
        {
            $appointment = $this->appointmentRepository->findWhere(['free_time_id' => $data['free_time_id']])->first();
            if (!is_null($appointment)) {
                return DataReturn::Result(status: HttpCode::BAD_REQUEST);
            }
            $freeTime = $this->freeTimeRepository->findWhere(['id' => $data['free_time_id']])->first();
            $listTime = $this->appointmentRepository->checkAppointment($data, $freeTime);
            if (count($listTime)) {
                return DataReturn::Result(status: HttpCode::BAD_REQUEST);
            }
            $this->freeTimeRepository->update(['is_active' => false], $data['free_time_id']);
            return DataReturn::Result($this->appointmentRepository->create($data));
        }

        public function getAllAppointment()
        {
            return DataReturn::Result($this->appointmentRepository->all());
        }

        public function getAppointmentById($id)
        {
            if (!$this->checkAppointmentIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->appointmentRepository->findWhere(['id' => $id]));
        }

        public function getAppointmentByDoctorId($id, $param)
        {
            if (!$this->checkDoctorIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->doctorRepository->getAppointmentByDoctorId($id, $param));
        }

        public function getAppointmentAllDoctor($param)
        {
            return DataReturn::Result($this->doctorRepository->getAppointmentAllDoctor($param));
        }

        public function getAppointmentByPatientId($id, $param)
        {
            if (is_null($this->accountRepository->findWhere(['id' => $id])->first())) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->accountRepository->getAppointmentByPatientId($id, $param));
        }

        public function getAppointmentAllPatient($param)
        {
            return DataReturn::Result($this->accountRepository->getAppointmentAllPatient($param));
        }

        public function checkAppointmentIsExist($id)
        {
            return !is_null($this->appointmentRepository->findWhere(['id' => $id])->first());
        }

        public function checkDoctorIsExist($id)
        {
            return !is_null($this->doctorRepository->findWhere(['id' => $id])->first());
        }

        public function update($data, $id)
        {
            if (!$this->checkAppointmentIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->appointmentRepository->update($data, $id));
        }

        public function delete($id)
        {
            if (!$this->checkAppointmentIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->appointmentRepository->delete($id));
        }
    }
