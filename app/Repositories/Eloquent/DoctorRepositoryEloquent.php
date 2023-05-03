<?php

    namespace App\Repositories\Eloquent;

    use App\Models\Account;
    use App\Models\Doctor;
    use App\Models\Information;
    use App\Repositories\AccountRepository;
    use App\Repositories\AddressRepository;
    use App\Repositories\DoctorRepository;
    use App\Repositories\InformationRepository;
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
    }
