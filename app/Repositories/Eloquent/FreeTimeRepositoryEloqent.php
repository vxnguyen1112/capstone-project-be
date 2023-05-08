<?php

    namespace App\Repositories\Eloquent;

    use App\Exceptions\FreetimeException;
    use App\Helpers\FreeTimeMessage;
    use App\Models\Free_time;
    use App\Models\Role;
    use App\Repositories\FreeTimeRepository;
    use App\Repositories\RoleRepository;
    use Illuminate\Support\Facades\Log;
    use Prettus\Repository\Criteria\RequestCriteria;
    use Prettus\Repository\Eloquent\BaseRepository;


    class FreeTimeRepositoryEloqent extends BaseRepository implements FreeTimeRepository
    {
        public function model()
        {
            return Free_time::class;
        }

        public function boot()
        {
            $this->pushCriteria(app(RequestCriteria::class));
        }

        public function storeFreeTime($data)
        {
            $freeTime = Free_time::where([
                'doctor_id' => $data['doctor_id'],
                ['startTime', '<=', $data['startTime']],
                ['endTime', '>', $data['startTime']]
            ])->orWhere(function ($query) use ($data) {
                $query->where([
                    'doctor_id' => $data['doctor_id'],
                    ['startTime', '<', $data['endTime']],
                    ['endTime', '>=', $data['endTime']]
                ]);
            }
            )->orWhere(function ($query) use ($data) {
                $query->where([
                    'doctor_id' => $data['doctor_id'],
                    ['startTime', '>=', $data['startTime']],
                    ['endTime', '<=', $data['endTime']]
                ]);
            }
            )->exists();
            if ($freeTime) {
                throw new FreetimeException(FreeTimeMessage::CONFlICT_DATE);
            }
        }
    }
