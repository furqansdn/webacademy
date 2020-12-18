<?php

namespace App\Models\Discussion;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{

    protected $guarded = [];

    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
