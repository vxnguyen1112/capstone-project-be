<?php

    namespace App\Repositories\Eloquent;

    use App\Models\Blog;
    use App\Models\Role;
    use App\Repositories\BlogRepository;
    use Prettus\Repository\Criteria\RequestCriteria;
    use Prettus\Repository\Eloquent\BaseRepository;


    class BlogRepositoryEloquent extends BaseRepository implements BlogRepository
    {
        public function model()
        {
            return Blog::class;
        }

        public function boot()
        {
            $this->pushCriteria(app(RequestCriteria::class));
        }

        public function getAllBlog()
        {
            return Blog::withCount('comment')->with('account')->latest()->get();
        }
    }
