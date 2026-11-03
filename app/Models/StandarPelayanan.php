<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandarPelayanan extends Model
{
    use HasFactory;

    protected $table = 'standar_pelayanans';

    protected $fillable = [
        'title',
        'file_path',
        'file_size',
        'uploaded_at',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];
}
