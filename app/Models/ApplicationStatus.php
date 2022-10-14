<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationStatus extends Model
{
    use HasFactory;

    protected $fillable = ['application_id', 'status_id', 'last_updated'];

    protected $appends = ['status_name'];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
    public function getStatusNameAttribute()
    {
        return $this->status->name ?? '';
    }
}
