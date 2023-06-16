<?php

    namespace App\Http\Controllers\api;

    use App\Helpers\CommonResponse;
    use App\Helpers\HttpCode;
    use App\Helpers\ResponseHelper;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\StoreDoctorRequest;
    use App\Http\Requests\StoreRoleRequest;
    use App\Services\DoctorService;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class DoctorController extends Controller
    {
        protected $doctorService;

        public function __construct(DoctorService $doctorService)
        {
            $this->doctorService = $doctorService;
        }

        public function store(StoreDoctorRequest $request)
        {
            try {
                DB::beginTransaction();
                $result = $this->doctorService->store($request->all());
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

        public function getDoctorById($id)
        {
            $result = $this->doctorService->getDoctorById($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }
        public function getPatientOfDoctor(Request $request)
        {
            $result = $this->doctorService->getPatientOfDoctor($request['id'],$request->all());
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }

        public function getAllDoctor(Request $request)
        {
            $result = $this->doctorService->getAllDoctor($request->all());
            return ResponseHelper::send($result['data']);
        }

        public function getFreeTimeAllDoctor(Request $request)
        {
            $result = $this->doctorService->getFreeTimeAllDoctor($request->all());
            return ResponseHelper::send($result['data']);
        }

        public function getFreeTimeByDoctorId(Request $request, $id)
        {
            $result = $this->doctorService->getFreeTimeByDoctorId($id, $request->all());
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }

        public function update(Request $request, $id)
        {
            $result = $this->doctorService->update($request->all(), $id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }

        public function destroy($id)
        {
            $result = $this->doctorService->delete($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return CommonResponse::deleteSuccessfullyResponse();
        }
    }
