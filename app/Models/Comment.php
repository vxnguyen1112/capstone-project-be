<?php

    namespace App\Models;

    use App\Helpers\UUID;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Comment extends Model
    {
        use HasFactory;
        use UUID;

        protected $fillable = [
            'content',
            'parent_id',
            'account_id',
            'blog_id',
        ];
        protected $with = array('replies', 'account');

        public function account()
        {
            return $this->belongsTo(Account::class);
        }

        public function replies()
        {
            return $this->hasMany(Comment::class, 'parent_id');
        }


    }
