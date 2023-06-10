<?php

    namespace App\Observers;

    use App\Events\Event;
    use App\Models\Appointment;
    use App\Services\AppointmentService;
    use App\Services\NotificationService;
    use Illuminate\Support\Facades\Log;

    class AppointmentObserver
    {
        protected $appointmentService;

        protected $notificationService;

        protected $shareEvent;

        public function __construct(AppointmentService $appointmentService, NotificationService $notificationService)
        {
            $this->appointmentService = $appointmentService;
            $this->notificationService = $notificationService;
        }

        /**
         * Handle the Appointment "created" event.
         *
         * @param \App\Models\Appointment $appointment
         * @return void
         */
        public function created(Appointment $appointment)
        {
            $result = $this->appointmentService->getAppointmentById($appointment['id'])['data']->toArray()[0];
            $description = "<b class='text-displayname'>" . $result['patient']['display_name'] . "</b> đặt lịch khám với bạn  vào lúc <b class='text-time'>" . $result['time']['startTime'] . "</b>";
            $data = [
                'content' => $description,
                'link' => '/appointment',
                'account_id' => $appointment['patient_id'],
                'to_account_id' => $result['doctor']['account']['id']
            ];
            $notification = $this->notificationService->store($data);
            $this->shareEvent = new Event($result['doctor']['account']['id']);
            event($this->shareEvent->create('notification', $appointment['patient_id'], $notification));
            event($this->shareEvent->create('freetime', $appointment['patient_id'], $result['time']));
        }

        /**
         * Handle the Appointment "updated" event.
         *
         * @param \App\Models\Appointment $appointment
         * @return void
         */
        public function updated(Appointment $appointment)
        {
            $result = $this->appointmentService->getAppointmentById($appointment['id'])['data']->toArray()[0];
            $description = "<b class='text-displayname'>" . $result['doctor']['account']['display_name'] . "</b> đã <b class='text-status'> " . $appointment['status'] . " </b> lịch khám của bạn";
            $data = [
                'content' => $description,
                'link' => '/appointments',
                'account_id' => $result['doctor']['account']['id'],
                'to_account_id' => $appointment['patient_id']
            ];
            $notification = $this->notificationService->store($data);
            $this->shareEvent = new Event($appointment['patient_id']);
            event($this->shareEvent->create('notification', $result['doctor']['account']['id'], $notification));

        }

        /**
         * Handle the Appointment "deleted" event.
         *
         * @param \App\Models\Appointment $appointment
         * @return void
         */
        public function deleted(Appointment $appointment)
        {
            //
        }

        /**
         * Handle the Appointment "restored" event.
         *
         * @param \App\Models\Appointment $appointment
         * @return void
         */
        public function restored(Appointment $appointment)
        {
            //
        }

        /**
         * Handle the Appointment "force deleted" event.
         *
         * @param \App\Models\Appointment $appointment
         * @return void
         */
        public function forceDeleted(Appointment $appointment)
        {
            //
        }
    }
