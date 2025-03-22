<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    use HasFactory;

    protected $table = 'medications';

    public $timestamps = false;
    
    protected $fillable = ['user_id', 'name', 'time'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    protected $guarded = [];

}
