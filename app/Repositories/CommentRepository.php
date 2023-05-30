<?php

    namespace App\Repositories;

    use Prettus\Repository\Contracts\RepositoryInterface;

    interface CommentRepository extends RepositoryInterface
    {
        public function getCommentByBlog($id);
    }
