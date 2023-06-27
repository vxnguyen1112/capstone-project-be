<?php

    namespace App\Http\Controllers\api;

    use App\Helpers\CommonResponse;
    use App\Helpers\HttpCode;
    use App\Helpers\ResponseHelper;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\StoreMedicationRequest;
    use App\Http\Requests\StoreRoleRequest;
    use App\Http\Requests\StoreStudyingHistoryRequest;
    use App\Services\ExperienceService;
    use App\Services\StudyingHistoryService;
    use Illuminate\Http\Request;

    class StudyingHistoryController extends Controller
    {
        protected $studyingHistoryService;

        public function __construct(StudyingHistoryService $studyingHistoryService)
        {
            $this->studyingHistoryService = $studyingHistoryService;
        }

        public function store(StoreStudyingHistoryRequest $request)
        {
            $result = $this->studyingHistoryService->store($request->all());
            return ResponseHelper::send($result['data'], statusCode: HttpCode::CREATED);
        }

        public function getStudyingHistoryById($id)
        {
            $result = $this->studyingHistoryService->getStudyingHistoryById($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }
        public function getStudyingHistoryByDoctorId($id)
        {
            $result = $this->studyingHistoryService->getStudyingHistoryByDoctorId($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }
        public function update(Request $request, $id)
        {
            $result = $this->studyingHistoryService->update($request->all(), $id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }

        public function destroy($id)
        {
            $result = $this->studyingHistoryService->delete($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return CommonResponse::deleteSuccessfullyResponse();
        }
    }
