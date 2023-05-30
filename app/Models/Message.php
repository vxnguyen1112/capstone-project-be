<?php

    namespace App\Models;

    use App\Helpers\UUID;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Message extends Model
    {
        use HasFactory;
        use UUID;

        protected $fillable = [
            'account_id',
            'to_account_id',
            'type',
            'content'
        ];

    }
