<?php

namespace App;

use Carbon\Carbon;

class Post extends Model
{
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function addComment($body)
    {
//        Comment::create([
//            'body' => $body,
//            'post_id' => $this->id
//        ]);

//        $this->comments()->create(['body' => $body]);

        $this->comments()->create(compact('body'));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, $filters)
    {
        if ($month = $filters['month']) {
            $query->whereMonth('created_at', Carbon::parse($month)->month);
        }


        if ($year = $filters['year']) {
            $query->whereYear('created_at', $year);
        }
    }
}
