<?php

namespace App\Models\Quiz;

use App\User;
use App\Models\Quiz\QuestionOption;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Question extends Model
{
    protected $guarded = [];
    protected $with = ['questionOptions', 'users'];

    public function questionOptions()
    {
        return $this->hasMany(QuestionOption::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_answers')->where('user_id', Auth::user()->id)
            ->withPivot('mark_code');
    }

}
