<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
  use HasFactory;

  protected $fillable = ['image', 'user_id'];

  public function users()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }
}