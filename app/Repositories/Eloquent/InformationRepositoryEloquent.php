<?php

    namespace App\Repositories\Eloquent;

    use App\Models\Account;
    use App\Models\Information;
    use App\Repositories\AccountRepository;
    use App\Repositories\AddressRepository;
    use App\Repositories\InformationRepository;
    use Prettus\Repository\Criteria\RequestCriteria;
    use Prettus\Repository\Eloquent\BaseRepository;


    class InformationRepositoryEloquent extends BaseRepository implements InformationRepository
    {

        public function model()
        {
            return Information::class;
        }

        public function boot()
        {
            $this->pushCriteria(app(RequestCriteria::class));
        }

    }
