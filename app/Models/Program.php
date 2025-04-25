<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    // A program has many clients
    public function clients()
    {
        return $this->belongsToMany(Client::class, 'enrollments');
    }

    // A program has many program logs
    public function programLogs()
    {
        return $this->hasMany(ProgramLog::class);
    }
}

