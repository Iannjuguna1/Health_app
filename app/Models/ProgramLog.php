<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramLog extends Model
{
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}

