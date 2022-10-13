<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationStatus extends Model
{
    use HasFactory;

    protected $fillable = ['application_id', 'status', 'last_updated'];
    const STATUSES = [
        'AKTIF', 'SUSPEND'
    ];
}
