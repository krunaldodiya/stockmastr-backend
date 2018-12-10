<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class News extends Model
{
    protected $fillable = [
        'title', 'description', 'content', 'source_url', 'image_url', 'published_at', 'created_at', 'updated_at',
    ];

    protected $appends = ['published_at_readable'];

    protected $dates = ['published_at', 'created_at', 'updated_at'];

    public function getPublishedAtReadableAttribute()
    {
        $date = $this->attributes['published_at'];
        return (new Carbon($date))->diffForHumans();
    }
}
