<?php

    namespace App\Http\Controllers\api;

    use App\Helpers\CommonResponse;
    use App\Helpers\HttpCode;
    use App\Helpers\ResponseHelper;
    use App\Helpers\Status;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\StoreAppointmentRequest;
    use App\Services\AppointmentService;
    use Illuminate\Http\Request;

    class AppointmentController extends Controller
    {
        protected $appointmentService;

        public function __construct(AppointmentService $appointmentService)
        {
            $this->appointmentService = $appointmentService;
        }

        public function store(StoreAppointmentRequest $request)
        {
            $result = $this->appointmentService->store($request->all());
            if ($result['status'] === HttpCode::BAD_REQUEST) {
                $message = 'The time you booked is not available.';
                return ResponseHelper::send([], Status::NOT_GOOD, HttpCode::BAD_REQUEST, $message);
            }
            return ResponseHelper::send($result['data'], statusCode: HttpCode::CREATED);
        }

        public function getAllAppointment()
        {
            $result = $this->appointmentService->getAllAppointment();
            return ResponseHelper::send($result['data'], statusCode: HttpCode::CREATED);
        }
        public function getAppointmentById($id)
        {
            $result = $this->appointmentService->getAppointmentById($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }
        public function getAppointmentAllDoctor(Request $request)
        {
            $result = $this->appointmentService->getAppointmentAllDoctor($request->all());
            return ResponseHelper::send($result['data']);
        }

        public function getAppointmentByDoctorId(Request $request, $id)
        {
            $result = $this->appointmentService->getAppointmentByDoctorId($id, $request->all());
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }
        public function getAppointmentAllPatient(Request $request)
        {
            $result = $this->appointmentService->getAppointmentAllPatient($request->all());
            return ResponseHelper::send($result['data']);
        }

        public function getAppointmentByPatientId(Request $request, $id)
        {
            $result = $this->appointmentService->getAppointmentByPatientId($id, $request->all());
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }

        public function update(Request $request, $id)
        {
            $result = $this->appointmentService->update($request->all(), $id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }

        public function destroy($id)
        {
            $result = $this->appointmentService->delete($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return CommonResponse::deleteSuccessfullyResponse();
        }
    }
