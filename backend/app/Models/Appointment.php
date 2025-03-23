<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'name',
        'time',
        'department',
        'location',
    ];

    // Randevu, bir kullanıcıya ait
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
