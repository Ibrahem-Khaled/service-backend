<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }

    public function providers()
    {
        return $this->hasMany(User::class, 'sub_categories_id', 'id');
    }
}
