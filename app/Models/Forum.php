<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categorys_id', 'id');
    }

    public function context()
    {
        return $this->belongsTo(Context::class, 'contexts_id', 'id');
    }
}
