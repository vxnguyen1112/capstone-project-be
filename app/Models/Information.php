<?php

    namespace App\Models;

    use App\Helpers\UUID;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Information extends Model
    {
        use HasFactory;
        use UUID;

        protected $fillable = [
            'first_name',
            'last_name',
            'gender',
            'phone',
            'address_id'
        ];

        public function address()
        {
            return $this->belongsTo(Address::class);
        }
    }
