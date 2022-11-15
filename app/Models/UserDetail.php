<?php

namespace App\Models;

use App\Models\Event as ModelsEvent;
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

    // public function event()
    // {
    //     return $this->hasMany(ModelsEvent::class, 'user_id', 'user_id');
    // }
}
