<?php

    namespace App\Repositories\Eloquent;


    use App\Http\Controllers\api\MessageController;
    use App\Models\Message;
    use App\Repositories\MessageRepository;
    use Prettus\Repository\Criteria\RequestCriteria;
    use Prettus\Repository\Eloquent\BaseRepository;


    class MessageRepositoryEloquent extends BaseRepository implements MessageRepository
    {
        public function model()
        {
            return Message::class;
        }

        public function boot()
        {
            $this->pushCriteria(app(RequestCriteria::class));
        }

        public function getAllConversation($id)
        {
            return Message::where(['account_id' => $id])->orWhere(['to_account_id' => $id])->select([
                'account_id',
                'to_account_id'
            ])->latest()->get();
        }

        public function getMessageByIdAccount($id)
        {
            return Message::where([
                'account_id' => auth()->user()['id'],
                'to_account_id' => $id
            ])->orWhere(function ($query) use ($id) {
                $query->where([
                    'account_id' => $id,
                    'to_account_id' => auth()->user()['id']
                ]);
            })->latest('updated_at')->get();
        }
    }
