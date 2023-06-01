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
            'image'
        ];

        public function account()
        {
            return $this->belongsTo(Account::class);
        }

        public function comments()
        {
            return $this->hasMany(Comment::class)->whereNull('parent_id')->oldest();
        }

    }
