<?php

    namespace App\Models;

    use App\Helpers\UUID;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Blog extends Model
    {
        use HasFactory;
        use UUID;

        protected $fillable = [
            'title',
            'body',
            'account_id',
        ];
        public function account()
        {
            return $this->belongsTo(Account::class);
        }

    }
