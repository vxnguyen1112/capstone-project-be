<?php

    namespace App\Repositories\Eloquent;

    use App\Models\Experience;
    use App\Repositories\ExperienceRepository;
    use Prettus\Repository\Criteria\RequestCriteria;
    use Prettus\Repository\Eloquent\BaseRepository;


    class ExperienceRepositoryEloquent extends BaseRepository implements ExperienceRepository
    {
        public function model()
        {
            return Experience::class;
        }

        public function boot()
        {
            $this->pushCriteria(app(RequestCriteria::class));
        }

    }
