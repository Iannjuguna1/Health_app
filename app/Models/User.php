<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    // A doctor can be assigned to many clients
    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_user');
    }

    // A doctor may have many appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}

