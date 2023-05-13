<?php

    namespace App\Models;

    use App\Helpers\UUID;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Free_time extends Model
    {
        use HasFactory;
        use UUID;

        protected $fillable = [
            'startTime',
            'endTime',
            'is_active',
            'doctor_id',
        ];

    }
