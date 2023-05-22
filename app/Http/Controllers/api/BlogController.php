<?php

    namespace App\Http\Controllers\api;

    use App\Helpers\CommonResponse;
    use App\Helpers\HttpCode;
    use App\Helpers\ResponseHelper;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\StoreBlogRequest;
    use App\Http\Requests\StoreRoleRequest;
    use App\Services\BlogService;
    use Illuminate\Http\Request;

    class BlogController extends Controller
    {
        protected $blogService;

        public function __construct(BlogService $blogService)
        {
            $this->blogService = $blogService;
        }

        public function store(StoreBlogRequest $request)
        {
            $result = $this->blogService->store($request->all());
            return ResponseHelper::send($result['data'], statusCode: HttpCode::CREATED);
        }

        public function getAllBlog()
        {
            $result = $this->blogService->getAllBlog();
            return ResponseHelper::send($result['data'], statusCode: HttpCode::CREATED);
        }

        public function getBlogById($id)
        {
            $result = $this->blogService->getBlogById($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }

        public function update(Request $request, $id)
        {
            $result = $this->blogService->update($request->all(), $id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }

        public function destroy($id)
        {
            $result = $this->blogService->delete($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return CommonResponse::deleteSuccessfullyResponse();
        }
    }
