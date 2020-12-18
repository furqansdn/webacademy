<?php

namespace App\Models\Quiz;

use App\Models\Course\Series;
use App\Models\Quiz\Question;
use App\Models\Quiz\QuizProgress;
use Illuminate\Database\Eloquent\Model;
use Auth;
class Quiz extends Model
{
    protected $guarded = [];
    protected $with = ['user_quiz'];

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function quiz_progress()
    {
        return $this->hasMany(QuizProgress::class);
    }

    public function checkLastAttempt()
    {
        return $this->quiz_progress()->where('user_id', Auth::user()->id)->max('order');
    }

    public function user_quiz()
    {
        return $this->quiz_progress()->where('user_id', Auth::user()->id)->latest('order');
    }

}
