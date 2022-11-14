<?php

namespace App\Models;

use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getImagePathProfileAttribute()
    {
        return URL::to('/') . '/images/profile/' . $this->image;
    }
}