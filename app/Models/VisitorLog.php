<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'visited_date',
        'last_activity',
        'user_agent',
    ];

    protected $casts = [
        'visited_date' => 'date',
        'last_activity' => 'datetime',
    ];
}
