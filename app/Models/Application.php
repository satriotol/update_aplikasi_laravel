<?php

namespace App\Models;

use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory, DefaultDatetimeFormat;

    protected $fillable = ['category_id', 'whm_id', 'url', 'note', 'user_id'];
    const STATUSES = [
        'AKTIF', 'SUSPEND'
    ];
    protected $appends = ['status_name', 'status_created_at'];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function application_statuses()
    {
        return $this->hasMany(ApplicationStatus::class, 'application_id', 'id')->orderBy('id', 'desc');
    }
    public function getStatusNameAttribute()
    {
        return $this->application_statuses()->first()->status->name ?? '';
    }
    public function getStatusCreatedAtAttribute()
    {
        return $this->application_statuses()->first()->created_at ?? '';
    }
    public function whm()
    {
        return $this->belongsTo(Whm::class, 'whm_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(Administrator::class, 'user_id', 'id');
    }
}
