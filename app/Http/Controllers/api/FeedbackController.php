<?php

    namespace App\Http\Controllers\api;

    use App\Helpers\CommonResponse;
    use App\Helpers\HttpCode;
    use App\Helpers\ResponseHelper;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\StoreCommentRequest;
    use App\Http\Requests\StoreFeedbackRequest;
    use App\Http\Requests\StoreRoleRequest;
    use App\Services\CommentService;
    use App\Services\FeedbackService;
    use App\Services\RoleService;
    use Illuminate\Http\Request;

    class FeedbackController extends Controller
    {
        protected $feedbackService;

        public function __construct(FeedbackService $feedbackService)
        {
            $this->feedbackService = $feedbackService;
        }

        public function store(StoreFeedbackRequest $request)
        {
            $result = $this->feedbackService->store($request->all());
            return ResponseHelper::send($result['data'], statusCode: HttpCode::CREATED);
        }

        public function getFeedbackByDoctor($id)
        {
            $result = $this->feedbackService->getFeedbackByDoctor($id);
            return ResponseHelper::send($result['data']);
        }
        public function getFeedbackById($id)
        {
            $result = $this->feedbackService->getFeedbackById($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }

        public function update(Request $request, $id)
        {
            $result = $this->feedbackService->update($request->all(), $id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }

        public function destroy($id)
        {
            $result = $this->feedbackService->delete($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return CommonResponse::deleteSuccessfullyResponse();
        }
    }
