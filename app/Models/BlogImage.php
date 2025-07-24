<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogImage extends Model
{
    //
    protected $table = 'blog_images';

    protected $fillable = [
        'blog_id',
        'image_path',
        'image_type',
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
