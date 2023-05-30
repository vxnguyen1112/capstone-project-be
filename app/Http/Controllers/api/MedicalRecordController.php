<?php

    namespace App\Http\Controllers\api;

    use App\Exceptions\FreetimeException;
    use App\Helpers\CommonResponse;
    use App\Helpers\HttpCode;
    use App\Helpers\ResponseHelper;
    use App\Helpers\Status;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\StoreMedicalRecordRequest;
    use App\Http\Requests\StoreRoleRequest;
    use App\Services\MedicalRecordService;
    use App\Services\RoleService;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class MedicalRecordController extends Controller
    {
        protected $medicalRecordService;

        public function __construct(MedicalRecordService $medicalRecordService)
        {
            $this->medicalRecordService = $medicalRecordService;
        }

        public function store(StoreMedicalRecordRequest $request)
        {
            try {
                DB::beginTransaction();
                $result = $this->medicalRecordService->store($request->all());
                DB::commit();
                return ResponseHelper::send($result['data'], statusCode: HttpCode::CREATED);
            } catch (ModelNotFoundException $e) {
                Log::error($e);
                return CommonResponse::notFoundResponse();
            } catch (\Exception $e) {
                error_log($e);
                DB::rollBack();
                Log::error($e);
                return CommonResponse::unknownResponse();
            }
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
