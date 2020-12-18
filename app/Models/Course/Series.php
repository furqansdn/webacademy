<?php

namespace App\Models\Course;

use App\User;
use App\Models\Quiz\Quiz;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Auth;
class Series extends Model
{
    protected $guarded = [];
    // protected $with = ['lessons'];
    // auto generate slug berdasarkan title
    public static function boot()
    {
        parent::boot();
        static::creating(function($series){
            $series->slug = Str::slug($series->title);
        });
    }


    // Parameter menggunakan slug bukan id
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function series_takens()
    {
        return $this->hasMany(SeriesTaken::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'series_takens')->withTimestamps();
    }

    public function getFirstLessonId()
    {
        return $this->lessons()->first();
    }

    public function getNextLessons($episodeNumber)
    {
        return $this->lessons()->where('episode_number','>',$episodeNumber)->first();
    }

    public function getPreviusLessons()
    {
        // return $this->lessons()->where('episode_number','<', $this->lessons->episode_number)->first();
        return $this->lessons();
    }

    public function getOrderedLessons()
    {
        return $this->lessons()->orderBy('episode_number', 'asc')->get();
    }

    public function countLesson()
    {
        return $this->lessons()->count();
    }

    public function countQuiz()
    {
        return $this->quizzes()->count();
    }

    public function countLecture()
    {
        return $this->countLesson() + $this->countQuiz();
    }

    public function userProgress()
    {
        $userCourseProgress = Auth::user()->userSeriesCourseProgress($this->id);
        $userQuizProgress = Auth::user()->userSeriesQuizProgress($this->id);
        $totallecture = $this->countLecture();
        $progress = ($userCourseProgress + $userQuizProgress)/$totallecture * 100;
        return number_format($progress,2,'.','');
    }
}
