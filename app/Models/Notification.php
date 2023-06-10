<?php

    namespace App\Models;

    use App\Helpers\UUID;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Notification extends Model
    {
        use HasFactory;
        use UUID;

        protected $fillable = [
            'content',
            'link',
            'account_id',
            'to_account_id',
            'is_read'
        ];
        public function account()
        {
            return $this->belongsTo(Account::class,'account_id');
        }
    }
