<?php

    namespace App\Models;

    use App\Helpers\UUID;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Studying_history extends Model
    {
        use HasFactory;
        use UUID;

        protected $fillable = [
            'course',
            'start_date',
            'end_date',
            'doctor_id'
        ];

    }
