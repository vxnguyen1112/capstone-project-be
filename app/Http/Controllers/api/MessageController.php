<?php

    namespace App\Http\Controllers\api;

    use App\Events\Event;
    use App\Helpers\CommonResponse;
    use App\Helpers\HttpCode;
    use App\Helpers\ResponseHelper;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\StoreMessageRequest;
    use App\Http\Requests\StoreRoleRequest;
    use App\Services\MessageService;
    use App\Services\RoleService;
    use Illuminate\Http\Request;

    class MessageController extends Controller
    {
        protected $messageService;

        protected $messageEvent;

        public function __construct(MessageService $messageService)
        {
            $this->messageService = $messageService;
        }

        public function store(StoreMessageRequest $request)
        {
            $result = $this->messageService->store($request->all());
            $this->messageEvent = new Event($request['to_account_id']);
            event($this->messageEvent->create('send-message', auth()->user()['id'], $result['data']));
            return ResponseHelper::send($result['data'], statusCode: HttpCode::CREATED);
        }

        public function getAllConversation($id)
        {
            $result = $this->messageService->getAllConversation($id);
            return ResponseHelper::send($result['data'], statusCode: HttpCode::CREATED);
        }

        public function getMessageByIdAccount($id)
        {
            $result = $this->messageService->getMessageByIdAccount($id);
            return ResponseHelper::send($result['data'], statusCode: HttpCode::CREATED);
        }

        public function update(Request $request, $id)
        {
            $result = $this->messageService->update($request->all(), $id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }

        public function destroy($id)
        {
            $result = $this->messageService->delete($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return CommonResponse::deleteSuccessfullyResponse();
        }
    }
