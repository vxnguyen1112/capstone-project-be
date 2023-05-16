<?php

    namespace App\Http\Controllers\api;

    use App\Helpers\CommonResponse;
    use App\Helpers\HttpCode;
    use App\Helpers\ResponseHelper;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\StoreMedicalRecordRequest;
    use App\Http\Requests\StoreRoleRequest;
    use App\Services\MedicalRecordService;
    use App\Services\RoleService;
    use Illuminate\Http\Request;

    class MedicalRecordController extends Controller
    {
        protected $medicalRecordService;

        public function __construct(MedicalRecordService $medicalRecordService)
        {
            $this->medicalRecordService = $medicalRecordService;
        }

        public function store(StoreMedicalRecordRequest $request)
        {
            $result = $this->medicalRecordService->store($request->all());
            return ResponseHelper::send($result['data'], statusCode: HttpCode::CREATED);
        }


        public function getMedicalRecordById($id)
        {
            $result = $this->medicalRecordService->getMedicalRecordById($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }
        public function getMedicalRecordByPatientId($id)
        {
            $result = $this->medicalRecordService->getMedicalRecordByPatientId($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }
        public function getMedicalRecordByDoctorId($id)
        {
            $result = $this->medicalRecordService->getMedicalRecordByDoctorId($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }
        public function update(Request $request, $id)
        {
            $result = $this->medicalRecordService->update($request->all(), $id);
            if ($$result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }

        public function destroy($id)
        {
            $result = $this->medicalRecordService->delete($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return CommonResponse::deleteSuccessfullyResponse();
        }
    }
