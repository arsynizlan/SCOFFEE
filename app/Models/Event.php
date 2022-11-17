<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\URL;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'slug', 'body', 'image', 'date', 'user_id', 'status_publish'
    ];

    protected $dateFormat = 'U';

    public function getImagePathEventAttribute()
    {
        return URL::to('/') . '/images/events/' . $this->image;
    }
}
