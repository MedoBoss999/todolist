<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'user_id', 'title', 'description', 'status', 
        'start_date', 'end_date', 'start_time', 'end_time'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
