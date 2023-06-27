<?php

    namespace App\Repositories\Eloquent;

    use App\Models\Account;
    use App\Models\Role;
    use App\Repositories\AccountRepository;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Prettus\Repository\Criteria\RequestCriteria;
    use Prettus\Repository\Eloquent\BaseRepository;
    use Illuminate\Database\Eloquent\Builder;


    class AccountRepositoryEloquent extends BaseRepository implements AccountRepository
    {

        public function model()
        {
            return Account::class;
        }

        public function boot()
        {
            $this->pushCriteria(app(RequestCriteria::class));
        }

        public function getAppointmentAllPatient($param)
        {
            if (array_key_exists('date', $param)) {
                return Account::whereHas('role', function ($query) {
                    $query->where(['name' => \App\Helpers\Role::PATIENT]);
                })->with([
                        'appointments.doctor',
                        'appointments.time' => function ($query) use ($param) {
                            $query->whereDate('startTime', $param['date']);
                        }
                    ]
                )->get();
            }
            return Account::whereHas('role', function ($query) {
                $query->where(['name' => \App\Helpers\Role::PATIENT]);
            })->with([
                'appointments.time',
                'appointments.doctor.account'
            ])->has('appointments')->get();
        }

        public function getAppointmentByPatientId($id, $param)
        {
            if (array_key_exists('date', $param)) {
                return Account::where(['id' => $id])->with([
                        'appointments.doctor',
                        'appointments.time' => function ($query) use ($param) {
                            $query->whereDate('startTime', $param['date']);
                        }
                    ]
                )->get();
            }
            return Account::where(['id' => $id])->with([
                'appointments.time',
                'appointments.doctor.account'
            ])->get();
        }

        public function getAccountByArray($arr, $query = "")
        {
            $placeholders = implode(',', array_fill(0, count($arr), '?'));
            $result = Account::where('display_name', 'LIKE', "%{$query}%")->whereIn('id',
                $arr)->orderByRaw("field(id,{$placeholders})", $arr)->with(['information.address'])->get();
            return $result;
        }

    }
