<?php

    namespace App\Services;

    use App\Events\Event;
    use App\Helpers\AppointmentStatus;
    use App\Helpers\DataReturn;
    use App\Helpers\HttpCode;
    use App\Jobs\SendEmailJob;
    use App\Repositories\AccountRepository;
    use App\Repositories\AppointmentRepository;
    use App\Repositories\DoctorRepository;
    use App\Repositories\FreeTimeRepository;
    use App\Repositories\NotificationRepository;
    use App\Repositories\RoleRepository;
    use Illuminate\Support\Facades\Log;

    class AppointmentService
    {
        protected $appointmentRepository;
        protected $doctorRepository;
        protected $accountRepository;
        protected $freeTimeRepository;

        protected $notificationRepository;


        public function __construct(
            AppointmentRepository $appointmentRepository,
            DoctorRepository $doctorRepository,
            AccountRepository $accountRepository,
            FreeTimeRepository $freeTimeRepository,
            NotificationRepository $notificationRepository
        ) {
            $this->appointmentRepository = $appointmentRepository;
            $this->doctorRepository = $doctorRepository;
            $this->accountRepository = $accountRepository;
            $this->freeTimeRepository = $freeTimeRepository;
            $this->notificationRepository = $notificationRepository;
        }

        public function store($data)
        {
            $freeTime = $this->freeTimeRepository->findWhere(['id' => $data['free_time_id'],'is_active' => true])->first();
            if (is_null($freeTime)) {
                return DataReturn::Result(status: HttpCode::BAD_REQUEST);
            }
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
            return DataReturn::Result($this->appointmentRepository->with([ 'patient','doctor.account','time'])->findWhere(['id' => $id]));
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
            $result = $this->getAppointmentById($id)['data']->toArray()[0];
            $description = "<b class='text-displayname'>" . $result['patient']['display_name'] . "</b> đã hủy lịch khám với bạn  vào lúc <b class='text-time'>" . $result['time']['startTime'] . "</b>";
            $data = [
                'content' => $description,
                'link' => '/appointment',
                'account_id' => $result['patient_id'],
                'to_account_id' => $result['doctor']['account']['id']
            ];
            $notification = $this->notificationRepository->create($data);
            $this->shareEvent = new Event($result['doctor']['account']['id']);
            event($this->shareEvent->create('notification', $result['patient_id'], $notification));
            event($this->shareEvent->create('freetime', $result['patient_id'], $result['time']));
            $mailData = [
                'title' => 'Mail from Doctor Booking',
                'body' => $result['patient']['display_name'] . ' đã hủy lịch khám với bạn '. $result['time']['startTime'],
                'url' => env("URL_FE") . '/appointment'
            ];
            dispatch(new SendEmailJob($result['doctor']['account']['email'], $mailData));
            $this->freeTimeRepository->update(['is_active' => true], $result['free_time_id']);
            return DataReturn::Result($this->appointmentRepository->delete($id));
        }
    }
