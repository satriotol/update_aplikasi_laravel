<?php

namespace App\Models;

use Carbon\Carbon;
use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationStatus extends Model
{
    use HasFactory, DefaultDatetimeFormat;

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
    // public function getCreatedAtAttribute($date)
    // {
    //     return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    // }
}
