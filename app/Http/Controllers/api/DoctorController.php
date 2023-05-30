<?php

    namespace App\Http\Controllers\api;

    use App\Helpers\CommonResponse;
    use App\Helpers\HttpCode;
    use App\Helpers\ResponseHelper;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\StoreDoctorRequest;
    use App\Http\Requests\StoreRoleRequest;
    use App\Services\DoctorService;
    use Illuminate\Http\Request;

    class DoctorController extends Controller
    {
        protected $doctorService;

        public function __construct(DoctorService $doctorService)
        {
            $this->doctorService = $doctorService;
        }

        public function store(StoreDoctorRequest $request)
        {
            $result = $this->doctorService->store($request->all());
            return ResponseHelper::send($result['data'], statusCode: HttpCode::CREATED);
        }

        public function getDoctorById($id)
        {
            $result = $this->doctorService->getDoctorById($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }
        public function getPatientOfDoctor($id)
        {
            $result = $this->doctorService->getPatientOfDoctor($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }

        public function getAllDoctor()
        {
            $result = $this->doctorService->getAllDoctor();
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
            if ($$result['status'] === HttpCode::NOT_FOUND) {
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
