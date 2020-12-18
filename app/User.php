<?php

namespace App;

use App\Models\Course\Lesson;
use App\Models\Course\Series;
use App\Models\Quiz\Question;
use App\Models\Discussion\Like;
use App\Models\Discussion\Reply;
use App\Models\Quiz\QuizProgress;
use App\Models\Discussion\Discussion;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Membership\Subscription;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function series()
    {
        return $this->belongsToMany(Series::class,'series_takens')->withTimestamps();
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function progress()
    {
        return $this->belongsToMany(Lesson::class,'course_progress')->withTimestamps();
    }

    public function quiz_progresses()
    {
        return $this->hasMany(QuizProgress::class);
    }

    public function user_answers()
    {
        return $this->belongsToMany(Question::class, 'user_answers');
    }

    public function discussions()
    {
        return $this->hasMany(Discussion::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }


    public function userSeriesCourseProgress($seriesID)
    {
        return $this->progress()->where('series_id', $seriesID)->count();
    }

    public function userSeriesQuizProgress($seriesID)
    {
        // return $this->quiz_progresses()->where('series_id', $seriesID)
        // ->where('status', 1)->distinct('quiz_id')->count();

        return $this->quiz_progresses()
                    ->whereHas('quiz', function($query) use ($seriesID) {
                        return $query->where('series_id', $seriesID);
                    })
                    ->where('status', 1)->distinct('quiz_id')->count();
    }

    public function userLevels()
    {
        $point = 0;
        $userQuiz = $this->quiz_progresses()->select(\DB::raw('MAX(total_score) as score'))
                                            ->where('status', 1)
                                            ->groupBy('quiz_id')->pluck('score');
        $userCourse = $this->progress()->count();

        $totalScore = 0;
        foreach ($userQuiz as $item) {
            $totalScore+=$item;
        }

        $point = ($totalScore*50)+($userCourse*200);

        return $point;
    }
    
    public function isSubscribed()
    {
        return $this->subscriptions()->where('end_at', '>', date('Y-m-d H:i:s'))
                    ->where('isPaid', 1)
                    ->count();
    }

    public function userLikes()
    {
        return $this->replies()
                    ->join('likes', 'likes.reply_id', '=', 'replies.id')
                    ->count();
    }

    public function isLessonComplete($lessonId)
    {
        return $this->progress()->where('lesson_id', $lessonId)->count();
    }

    public function isSeriesTaken($slug)
    {
        return $this->series()->where('slug', $slug)->count();
    }

    public function attachUserSeries($slug)
    {
        return $this->series()->attach($slug);
    }
    
    public function isLiked($reply)
    {
        return $this->likes()
        ->where('reply_id', $reply)
        ->count();
    }

}
