<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'job_id', 'id');
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'job_id', 'id');
    }
}
