<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Models\Discussion\Reply;
use App\Http\Controllers\Controller;
use Auth;
class LikeController extends Controller
{
    public function likeIt(Reply $reply)
    {  
        if (Auth::user()->isLiked($reply->id) == 0) {
            $reply->likes()->create([
                'user_id' => Auth()->id(),
            ]);
        }
        elseif(Auth::user()->isLiked($reply->id) == 1){
            $reply->likes()->where('user_id',Auth()->id())
                ->first()
                ->delete();
        }
    }

    public function unlikeIt(Reply $reply)
    {
        $reply->likes()->where('user_id',Auth()->id())->first()->delete();
    }
}
