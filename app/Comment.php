<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['body', 'user_id', 'discussion_id'];

    public function user()
    {
        //$comment->user
        return $this->belongsTo(User::class);
    }

    public function discussions()
    {
        //$comment-discussions
        return $this->belongsTo(Discussion::class,'discussion_id');
    }

    public function likes()
    {
        return $this->belongsToMany(Like::class);
    }

    public function scopeUpdatedAt()
    {
        return $this->created_at->diffForHumans();
    }
}
