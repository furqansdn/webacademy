<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    public static function getNextLevel($currentLevel)
    {
        return self::query()->where('level', $currentLevel+1)->first();
    }
}
