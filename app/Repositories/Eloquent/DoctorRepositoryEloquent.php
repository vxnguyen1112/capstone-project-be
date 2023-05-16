<?php

    namespace App\Repositories\Eloquent;

    use App\Models\Account;
    use App\Models\Doctor;
    use App\Models\Information;
    use App\Repositories\AccountRepository;
    use App\Repositories\AddressRepository;
    use App\Repositories\DoctorRepository;
    use App\Repositories\InformationRepository;
    use Illuminate\Support\Facades\Date;
    use Prettus\Repository\Criteria\RequestCriteria;
    use Prettus\Repository\Eloquent\BaseRepository;


    class DoctorRepositoryEloquent extends BaseRepository implements DoctorRepository
    {

        public function model()
        {
            return Doctor::class;
        }

        public function boot()
        {
            $this->pushCriteria(app(RequestCriteria::class));
        }

        public function getDoctorById($id)
        {
            return Doctor::where(['id' => $id])->with([
                'account'
            ])->get();
        }

        public function getAllDoctor()
        {
            return Doctor::with([
                'account'
            ])->get();
        }

        public function getFreeTimeAllDoctor($param)
        {
            if (array_key_exists('date', $param)) {
                if ($param['date'] === \date('Y-m-d')) {
                    return Doctor::with([
                            'account',
                            'free_times' => function ($query) use ($param) {
                                $query->whereDate('startTime', $param['date'])->where('startTime', '>=',
                                    \date('Y-m-d H:i:s'));
                            }
                        ]
                    )->has('free_times')->get();
                }
                return Doctor::with([
                        'account',
                        'free_times' => function ($query) use ($param) {
                            $query->whereDate('startTime', $param['date']);
                        }
                    ]
                )->has('free_times')->get();
            }
            return Doctor::with([
                'account',
                'free_times' => function ($query) {
                    $query->where('startTime', '>=', \date('Y-m-d H:i:s'));
                }
            ])->whereHas('free_times', function ($query) {
                $query->where('startTime', '>=', \date('Y-m-d H:i:s'));
            })->get();
        }

        public function getFreeTimeByDoctorId($id, $param)
        {
            if (array_key_exists('date', $param)) {
                if ($param['date'] === \date('Y-m-d')) {
                    return Doctor::where(['id' => $id])->with([
                            'account',
                            'free_times' => function ($query) use ($param) {
                                $query->whereDate('startTime', $param['date'])->where('startTime', '>=',
                                    \date('Y-m-d H:i:s'));
                            }
                        ]
                    )->get();
                }
                return Doctor::where(['id' => $id])->with([
                        'account',
                        'free_times' => function ($query) use ($param) {
                            $query->whereDate('startTime', $param['date']);
                        }
                    ]
                )->get();
            }
            return Doctor::where(['id' => $id])->with([
                'account',
                'free_times' => function ($query) use ($param) {
                    $query->where('startTime', '>=', \date('Y-m-d H:i:s'));
                }
            ])->get();
        }

        public function getAppointmentAllDoctor($param)
        {
            if (array_key_exists('date', $param)) {
                return Doctor::with([
                        'appointments.patient',
                        'appointments.time' => function ($query) use ($param) {
                            $query->whereDate('startTime', $param['date']);
                        }
                    ]
                )->get();
            }
            return Doctor::with([
                'appointments.time',
                'appointments.patient'
            ])->get();
        }

        public function getAppointmentByDoctorId($id, $param)
        {
            if (array_key_exists('date', $param)) {
                return Doctor::where(['id' => $id])->with([
                        'appointments.patient',
                        'appointments.time' => function ($query) use ($param) {
                            $query->whereDate('startTime', $param['date']);
                        }
                    ]
                )->get();
            }
            return Doctor::where(['id' => $id])->with([
                'appointments.patient.information.address',
                'appointments.time'
            ])->get();
        }
    }
