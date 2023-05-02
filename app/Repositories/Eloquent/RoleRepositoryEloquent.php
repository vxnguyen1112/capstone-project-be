<?php

    namespace App\Repositories\Eloquent;

    use App\Models\Role;
    use App\Repositories\RoleRepository;
    use Prettus\Repository\Criteria\RequestCriteria;
    use Prettus\Repository\Eloquent\BaseRepository;


    class RoleRepositoryEloquent extends BaseRepository implements RoleRepository
    {
        public function model()
        {
            return Role::class;
        }

        public function boot()
        {
            $this->pushCriteria(app(RequestCriteria::class));
        }

    }
