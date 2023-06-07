<?php

    namespace App\Models;

    use App\Helpers\UUID;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Feedback extends Model
    {
        use HasFactory;
        use UUID;

        protected $fillable = [
            'content',
            'star',
            'account_id',
            'doctor_id',
        ];

        public function account()
        {
            return $this->belongsTo(Account::class);
        }

    }
