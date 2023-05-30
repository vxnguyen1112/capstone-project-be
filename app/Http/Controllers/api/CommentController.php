<?php

    namespace App\Http\Controllers\api;

    use App\Helpers\CommonResponse;
    use App\Helpers\HttpCode;
    use App\Helpers\ResponseHelper;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\StoreCommentRequest;
    use App\Http\Requests\StoreRoleRequest;
    use App\Services\CommentService;
    use App\Services\RoleService;
    use Illuminate\Http\Request;

    class CommentController extends Controller
    {
        protected $commentService;

        public function __construct(CommentService $commentService)
        {
            $this->commentService = $commentService;
        }

        public function store(StoreCommentRequest $request)
        {
            $result = $this->commentService->store($request->all());
            return ResponseHelper::send($result['data'], statusCode: HttpCode::CREATED);
        }

        public function getCommentByBlog($id)
        {
            $result = $this->commentService->getCommentByBlog($id);
            return ResponseHelper::send($result['data']);
        }
        public function getCommentById($id)
        {
            $result = $this->commentService->getCommentById($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }

        public function update(Request $request, $id)
        {
            $result = $this->commentService->update($request->all(), $id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }

        public function destroy($id)
        {
            $result = $this->commentService->delete($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return CommonResponse::deleteSuccessfullyResponse();
        }
    }
