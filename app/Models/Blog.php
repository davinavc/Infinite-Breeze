<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blog';

    protected $fillable = [
        'title',
        'content',
        'description',
        'category',
        'status',
        'event_id',
    ];

    public function images()
    {
        return $this->hasMany(BlogImage::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

}
