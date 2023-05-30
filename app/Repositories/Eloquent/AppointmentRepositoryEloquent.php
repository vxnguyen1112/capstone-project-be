<?php

    namespace App\Repositories\Eloquent;


    use App\Helpers\AppointmentStatus;
    use App\Models\Appointment;
    use App\Repositories\AppointmentRepository;
    use Prettus\Repository\Criteria\RequestCriteria;
    use Prettus\Repository\Eloquent\BaseRepository;


    class AppointmentRepositoryEloquent extends BaseRepository implements AppointmentRepository
    {

        public function model()
        {
            return Appointment::class;
        }

        public function boot()
        {
            $this->pushCriteria(app(RequestCriteria::class));
        }

        public function checkAppointment($data, $freeTime)
        {
            return Appointment::where([
                ['status', '<>', AppointmentStatus::DECLINE]
            ])->whereHas('time', function ($query) use ($freeTime) {
                $query->where([
                    ['startTime', '<=', $freeTime['startTime']],
                    ['endTime', '>', $freeTime['startTime']]
                ])->orWhere(function ($query) use ($freeTime) {
                    $query->where([
                        ['startTime', '<', $freeTime['endTime']],
                        ['endTime', '>=', $freeTime['endTime']]
                    ]);
                }
                )->orWhere(function ($query) use ($freeTime) {
                    $query->where([
                        ['startTime', '>=', $freeTime['startTime']],
                        ['endTime', '<=', $freeTime['endTime']]
                    ]);
                }
                );
            })->get();
        }

        public function getIdPatientOfDoctor($id)
        {
           return Appointment::where(['doctor_id'=>$id,'status'=>AppointmentStatus::ACCEPT])->select('patient_id')->latest('updated_at')->get();
        }
    }
