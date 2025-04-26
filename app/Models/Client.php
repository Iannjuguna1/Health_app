<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//log when a client is created
use Illuminate\Support\Facades\Log;
//factories for tests
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;
    //enable recovery of deleted records
    use SoftDeletes;


    //prevent mass assignments
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'email',
        'phone',
        'address',
        'date_of_birth',
    ];

    // A client can be enrolled in many programs (through enrollments)
    public function programs()
    {
        return $this->belongsToMany(Program::class, 'enrollments');
    }

    // A client can have many appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // A client can have multiple doctors
    public function users()
    {
        return $this->belongsToMany(User::class, 'client_user');
    }

    // A client can have many notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // A client can have many program logs
    public function programLogs()
    {
        return $this->hasMany(ProgramLog::class);
    }

    // Scope for filtering by gender
    public function scopeGender($query, $gender)
    {
        return $query->where('gender', $gender);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($client) {
            Log::info("Client created: {$client->first_name} {$client->last_name}");
        });
    }

}


