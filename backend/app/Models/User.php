<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users'; // Tablonun adı

    public $timestamps = false; // created_at ve updated_at kullanma

    protected $fillable = ['name', 'password']; // Doldurulabilir alanlar

    // Kullanıcının ilaçları
    public function medications()
    {
        return $this->hasMany(Medication::class, 'user_id');
    }

    // Kullanıcının randevuları
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'user_id');
    }

    // Kullanıcının fitness kayıtları
    public function fitnessLogs()
    {
        return $this->hasMany(FitnessLog::class, 'user_id');
    }
    
}
