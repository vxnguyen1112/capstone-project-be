<?php

    namespace App\Repositories\Eloquent;

    use App\Models\Blog;
    use App\Models\Comment;
    use App\Repositories\BlogRepository;
    use App\Repositories\CommentRepository;
    use Prettus\Repository\Criteria\RequestCriteria;
    use Prettus\Repository\Eloquent\BaseRepository;


    class CommentRepositoryEloquent extends BaseRepository implements CommentRepository
    {
        public function model()
        {
            return Comment::class;
        }

        public function boot()
        {
            $this->pushCriteria(app(RequestCriteria::class));
        }

        public function getCommentByBlog($id)
        {
            return Comment::where(['blog_id' => $id])->oldest()->get();
        }
    }
