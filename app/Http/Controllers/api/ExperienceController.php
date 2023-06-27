<?php

    namespace App\Http\Controllers\api;

    use App\Helpers\CommonResponse;
    use App\Helpers\HttpCode;
    use App\Helpers\ResponseHelper;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\StoreExperienceRequest;
    use App\Http\Requests\StoreMedicationRequest;
    use App\Http\Requests\StoreRoleRequest;
    use App\Services\ExperienceService;
    use Illuminate\Http\Request;

    class ExperienceController extends Controller
    {
        protected $experienceService;

        public function __construct(ExperienceService $experienceService)
        {
            $this->experienceService = $experienceService;
        }

        public function store(StoreExperienceRequest $request)
        {
            $result = $this->experienceService->store($request->all());
            return ResponseHelper::send($result['data'], statusCode: HttpCode::CREATED);
        }

        public function getExperienceById($id)
        {
            $result = $this->experienceService->getExperienceById($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }
        public function getExperienceByDoctorId($id)
        {
            $result = $this->experienceService->getExperienceByDoctorId($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }
        public function update(Request $request, $id)
        {
            $result = $this->experienceService->update($request->all(), $id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }

        public function destroy($id)
        {
            $result = $this->experienceService->delete($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return CommonResponse::deleteSuccessfullyResponse();
        }
    }
