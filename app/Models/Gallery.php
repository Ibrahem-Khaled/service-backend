<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
  use HasFactory;
  
  protected $fillable = ['image', 'provider_id'];
  
  public function provider()
  {
      return $this->belongsTo(Provider::class);
  }
}