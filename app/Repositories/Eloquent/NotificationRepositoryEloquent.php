<?php

    namespace App\Repositories\Eloquent;

    use App\Models\Notification;
    use App\Repositories\NotificationRepository;
    use Prettus\Repository\Criteria\RequestCriteria;
    use Prettus\Repository\Eloquent\BaseRepository;


    class NotificationRepositoryEloquent extends BaseRepository implements NotificationRepository
    {

        public function model()
        {
            return Notification::class;
        }

        public function boot()
        {
            $this->pushCriteria(app(RequestCriteria::class));
        }

        public function getNotification()
        {
            $account_id = auth()->user()['id'];
            error_log($account_id);
            Notification::where(["to_account_id" => $account_id, "is_read" => false])->update(['is_read' => true]);
            return Notification::where("to_account_id", $account_id)->with('account')->latest()->get();
        }

        public function checkNotification()
        {
            $account_id = auth()->user()['id'];
            return Notification::where(["to_account_id" => $account_id, "is_read" => false])->exists();
        }
    }
