<?php

namespace App\Models\Course;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $guarded = [];

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'course_progress')->withTimestamps();
    }

    public function getPreviusLesson()
    {
        return $this->series->lessons()->where('episode_number', '<' ,$this->episode_number)
                    ->orderBy('episode_number', 'desc')
                    ->first();
    }

    public function getNextLesson()
    {
        return $this->series->lessons()->where('episode_number', '>' ,$this->episode_number)
                    ->orderBy('episode_number', 'asc')
                    ->first();
    }

    public function getVideoNameAttribute()
    {
        $arr = explode("/", $this->video_path);
        return end($arr);
    }

    

}
