<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Discussion\Discussion;
use Auth;

class ReplyController extends Controller
{
    public function store(Request $request, Discussion $discussion)
    {
        $validate = $request->validate([
            'body' => 'required'
        ]);

        $data = Auth::user()->replies()->create([
            'discussion_id' => $discussion->id,
            'body' => $request->body,
        ]);

        return response()->json([
            'body' => $data->body,
            'name' => $data->user->name,
            'created_at' => $data->created_at->diffForHumans(),
            'url' => route('reply.like', $data->id),
        ]);
    }
}
