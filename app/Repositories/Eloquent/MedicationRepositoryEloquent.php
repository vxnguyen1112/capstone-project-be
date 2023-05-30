<?php

    namespace App\Repositories\Eloquent;

    use App\Models\Medication;
    use App\Repositories\MedicationRepository;
    use Prettus\Repository\Criteria\RequestCriteria;
    use Prettus\Repository\Eloquent\BaseRepository;


    class MedicationRepositoryEloquent extends BaseRepository implements MedicationRepository
    {
        public function model()
        {
            return Medication::class;
        }

        public function boot()
        {
            $this->pushCriteria(app(RequestCriteria::class));
        }

    }
