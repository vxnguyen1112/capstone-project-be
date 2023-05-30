<?php

    namespace App\Services;

    use App\Helpers\DataReturn;
    use App\Helpers\HttpCode;
    use App\Repositories\AccountRepository;
    use App\Repositories\MessageRepository;
    use Illuminate\Support\Facades\Log;

    class MessageService
    {
        protected $messageRepository;

        protected $accountRepository;

        /**
         * @param $messageRepository;
         * @param $accountRepository;
         */


        public function __construct(MessageRepository $messageRepository,AccountRepository $accountRepository)
        {
            $this->messageRepository = $messageRepository;
            $this->accountRepository = $accountRepository;
        }

        public function store($data)
        {
            $data['account_id']=auth()->user()['id'];
            return DataReturn::Result($this->messageRepository->create($data));
        }

        public function getAllConversation($id)
        {
            $listConversation=$this->messageRepository->getAllConversation($id)->toArray();
            $account_id = array_map(function($item) {
                return $item['account_id'];
            }, $listConversation);
            $to_account_id = array_map(function($item) {
                return $item['to_account_id'];
            }, $listConversation);
           $arr=array_values(array_unique(array_merge($account_id,$to_account_id)));
            if (($key = array_search($id, $arr)) !== false) {
                unset($arr[$key]);
            }
            return DataReturn::Result($this->accountRepository->findWhereIn('id', $arr));
        }
        public function getMessageByIdAccount($id)
        {
            return DataReturn::Result($this->messageRepository->getMessageByIdAccount($id));
        }

        public function checkMessageIsExist($id)
        {
            return !is_null($this->messageRepository->findWhere(['id' => $id])->first());
        }

        public function update($data, $id)
        {
            if (!$this->checkMessageIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->messageRepository->update($data, $id));
        }

        public function delete($id)
        {
            if (!$this->checkMessageIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->messageRepository->delete($id));
        }
    }
