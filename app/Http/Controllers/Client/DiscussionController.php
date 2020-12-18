<?php

namespace App\Http\Controllers\Client;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Discussion\Discussion;
use Auth;

class DiscussionController extends Controller
{
    public function index()
    {
        $discussion = Discussion::all();
        return view('client.discussion.index',compact('discussion'));
    }

    public function create()
    {
        return view('client.discussion.form');
    }

    public function store(Request $request)
    {
        $slug = Str::slug($request->title,'-');
        $discussion = Auth::user()->discussions()->create([
            'title' => $request->title,
            'body' => $request->body,
            'slug' => $slug
        ]);
    }

    public function show(Discussion $discussion)
    {
        return view('client.discussion.show',compact('discussion'));
    }
}
