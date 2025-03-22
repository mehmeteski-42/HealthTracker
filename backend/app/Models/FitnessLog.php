<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FitnessLog extends Model
{
    use HasFactory;

    protected $table = 'fitness_logs';

    public $timestamps = false;

    protected $fillable = ['user_id', 'repetitions', 'goal'];

    // Fitness kaydı, bir kullanıcıya ait
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
