<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;

class SeriesTaken extends Model
{
    protected $guarded = [];

    public function series()
    {
        return $this->belongsTo(Series::class);
    }
}
