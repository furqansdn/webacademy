<?php

namespace App\Models\Discussion;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{

    protected $appends = ['liked'];
    protected $guarded = [];

    public function reply()
    {
        return $this->belongsTo(Reply::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
