<?php

    namespace App\Repositories\Eloquent;

    use App\Models\Studying_history;
    use App\Repositories\StudyingHistoryRepository;
    use Prettus\Repository\Criteria\RequestCriteria;
    use Prettus\Repository\Eloquent\BaseRepository;


    class StudyingHistoryRepositoryEloquent extends BaseRepository implements StudyingHistoryRepository
    {
        public function model()
        {
            return Studying_history::class;
        }

        public function boot()
        {
            $this->pushCriteria(app(RequestCriteria::class));
        }

    }
