<?php

namespace App\Models\Quiz;

use App\Models\Quiz\Quiz;
use Illuminate\Database\Eloquent\Model;

class QuizProgress extends Model
{
    protected $guarded = [];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
