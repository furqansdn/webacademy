<?php

namespace App\Http\Controllers;

use Auth;
use App\Level;
use Illuminate\Http\Request;
use App\Models\Discussion\Reply;
use App\Models\Discussion\Discussion;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $point = Auth::user()->userLevels();
        $level = Level::where('min_point','<=',$point)->orderBy('min_point','DESC')->first();
        $next  = Level::getNextLevel($level->level);
        $progress = number_format(($point/$next->min_point) * 100,2,'.','');
        $latestcourse = Auth::user()->series()->orderBy('series_takens.created_at', 'DESC')->take(3)->get();
        $latestdiscussion = Discussion::myDiscussion()->orderBy('updated_at', 'DESC')->take(3)->get();
        
        return view('home',compact('latestcourse','level','point','next','progress','latestdiscussion'));
    }
    
}
