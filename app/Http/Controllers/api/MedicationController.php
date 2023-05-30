<?php

    namespace App\Http\Controllers\api;

    use App\Helpers\CommonResponse;
    use App\Helpers\HttpCode;
    use App\Helpers\ResponseHelper;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\StoreMedicationRequest;
    use App\Http\Requests\StoreRoleRequest;
    use App\Services\MedicationService;
    use Illuminate\Http\Request;

    class MedicationController extends Controller
    {
        protected $medicationService;

        public function __construct(MedicationService $medicationService)
        {
            $this->medicationService = $medicationService;
        }

        public function store(StoreMedicationRequest $request)
        {
            $result = $this->medicationService->store($request->all());
            return ResponseHelper::send($result['data'], statusCode: HttpCode::CREATED);
        }

        public function getMedicationById($id)
        {
            $result = $this->medicationService->getMedicationById($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }
        public function getMedicationByMedicalRecordId($id)
        {
            $result = $this->medicationService->getMedicationByMedicalRecordId($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }
        public function update(Request $request, $id)
        {
            $result = $this->medicationService->update($request->all(), $id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }

        public function destroy($id)
        {
            $result = $this->medicationService->delete($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return CommonResponse::deleteSuccessfullyResponse();
        }
    }
