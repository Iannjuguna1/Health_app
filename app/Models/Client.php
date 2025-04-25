<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
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
}

