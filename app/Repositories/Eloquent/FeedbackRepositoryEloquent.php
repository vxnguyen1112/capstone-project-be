<?php

    namespace App\Repositories\Eloquent;

    use App\Models\Comment;
    use App\Models\Feedback;
    use App\Repositories\BlogRepository;
    use App\Repositories\CommentRepository;
    use App\Repositories\FeedbackRepository;
    use Prettus\Repository\Criteria\RequestCriteria;
    use Prettus\Repository\Eloquent\BaseRepository;


    class FeedbackRepositoryEloquent extends BaseRepository implements FeedbackRepository
    {
        public function model()
        {
            return Feedback::class;
        }

        public function boot()
        {
            $this->pushCriteria(app(RequestCriteria::class));
        }

        public function getFeedbackByDoctor($id)
        {
            return Feedback::where(['doctor_id' => $id])->with(['account'])->oldest()->get();
        }
    }
