<?php

    namespace App\Services;

    use App\Helpers\DataReturn;
    use App\Helpers\HttpCode;
    use App\Repositories\BlogRepository;
    use App\Repositories\CommentRepository;
    use App\Repositories\RoleRepository;
    use Illuminate\Support\Facades\Log;

    class CommentService
    {
        protected $commentRepository;


        /**
         * @param $commentRepository
         */


        public function __construct(CommentRepository $commentRepository)
        {
            $this->commentRepository = $commentRepository;
        }

        public function store($data)
        {
            return DataReturn::Result($this->commentRepository->create($data));
        }

        public function getCommentByBlog($id)
        {
            return DataReturn::Result($this->commentRepository->getCommentByBlog($id));
        }

        public function getCommentById($id)
        {
            if (!$this->checkCommentIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->commentRepository->findWhere(['id' => $id]));
        }

        public function checkCommentIsExist($id)
        {
            return !is_null($this->commentRepository->findWhere(['id' => $id])->first());
        }

        public function update($data, $id)
        {
            if (!$this->checkCommentIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->commentRepository->update($data, $id));
        }

        public function delete($id)
        {
            if (!$this->checkCommentIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->commentRepository->delete($id));
        }
    }
