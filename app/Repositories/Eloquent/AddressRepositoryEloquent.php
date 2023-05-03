<?php

    namespace App\Repositories\Eloquent;

    use App\Models\Address;
    use App\Repositories\AddressRepository;
    use Prettus\Repository\Criteria\RequestCriteria;
    use Prettus\Repository\Eloquent\BaseRepository;


    class AddressRepositoryEloquent extends BaseRepository implements AddressRepository
    {

        public function model()
        {
            return Address::class;
        }

        public function boot()
        {
            $this->pushCriteria(app(RequestCriteria::class));
        }

    }
