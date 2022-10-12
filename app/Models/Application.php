<?php

namespace App\Models;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'whm_id', 'url', 'status', 'last_update', 'note', 'user_id'];
    const STATUSES = [
        'AKTIF', 'SUSPEND'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
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
