<?php

namespace App\Models\Discussion;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Auth;
class Discussion extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeMyDiscussion($query)
    {
        return $query->where('user_id', Auth::user()->id);
    }
    public function getTotalRepliesAttribute()
    {
        return $this->replies()->count();
    }
}
