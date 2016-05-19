<?php

namespace App;

use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    use SearchableTrait;

    protected $fillable = [
        'title','body','user_id','last_user_id'
    ];

    protected $searchable = [
        'columns' => [
            'title' => 1,
            'body' => 2,
        ]
    ];

    /**
     * $discussion->user 可以拿到帖子对应的用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getTagListAttribute()
    {
        return $this->tags->lists('id')->all();
    }

    public function scopeUpdatedAt()
    {
        return $this->created_at->diffForHumans();
    }

}
