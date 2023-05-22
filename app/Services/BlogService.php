<?php

    namespace App\Services;

    use App\Helpers\DataReturn;
    use App\Helpers\HttpCode;
    use App\Repositories\BlogRepository;
    use App\Repositories\RoleRepository;
    use Illuminate\Support\Facades\Log;

    class BlogService
    {
        protected $blogRepository;


        /**
         * @param $blogRepository
         */


        public function __construct(BlogRepository $blogRepository)
        {
            $this->blogRepository = $blogRepository;
        }

        public function store($data)
        {
            return DataReturn::Result($this->blogRepository->create($data));
        }

        public function getAllBlog()
        {
            return DataReturn::Result($this->blogRepository->with('account')->all());
        }

        public function getBlogById($id)
        {
            if (!$this->checkBlogIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->blogRepository->with('account')->findWhere(['id' => $id]));
        }

        public function checkBlogIsExist($id)
        {
            return !is_null($this->blogRepository->findWhere(['id' => $id])->first());
        }

        public function update($data, $id)
        {
            if (!$this->checkBlogIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->blogRepository->update($data, $id));
        }

        public function delete($id)
        {
            if (!$this->checkBlogIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->blogRepository->delete($id));
        }
    }
