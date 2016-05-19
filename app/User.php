<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'avatar', 'confirm_code', 'is_confirmed', 'nickname', 'weibo', 'github', 'blog', 'city', 'desc','remember_token'];

    /**
     * The attributes excluded from the model's JSON form.
     * @var array
     */
    protected $hidden = ['password', 'remember_token',];

    public function discussions()
    {
        //$user->$discussion 拿到用户对应的帖子
        return $this->hasMany(Discussion::class);
    }

    public function comments()
    {
        //$user->$comments 拿到用户对应的评论
        return $this->hasMany(Comment::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Discussion::class, 'favorites')->withTimestamps();
    }

    public function likes()
    {
        return $this->belongsToMany(Comment::class, 'likes')->withTimestamps();
    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }
        return !!$role->intersect($this->roles)->count();
    }
    //$user->roles()-attach($role);
    //role->permission()->save($role);
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = \Hash::make($password);
    }
}
