<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Course\Lesson;
use App\Models\Course\Series;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Series $series)
    {
        $lesson = new Lesson();
        return view('admin.lesson.form', compact('lesson','series'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Series $series)
    {
        $videoPath = request('video_path')->store('/lesson'.'/'.$series->slug,'public');
        $lesson = $series->lessons()->create([
            'title' => $request->title,
            'description' => $request->description,
            'episode_number' => $request->episode_number,
            'isPremium' => $request->isPremium,
            'video_path' => $videoPath, 
        ]);
        return $lesson;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Series $series, Lesson $lesson)
    {
        return view('admin.lesson.form', compact('series', 'lesson'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Series $series, Lesson $lesson)
    {
        if ($request->hasFile('video_path')) {
            if ($lesson->video_path) {
                // Fix This
                Storage::delete($lesson->video_path);
                $videoPath = request('video_path')->store('/lesson'.'/'.$series->slug,'public');
            }
            $lesson->video_path = $videoPath;
        }
        $lesson->title = $request->title;
        $lesson->episode_number = $request->episode_number;
        $lesson->isPremium = $request->isPremium;
        $lesson->description = $request->description;
        $lesson->save();

        return response()->json([
            'message' => 'Data Berhasil Diubah'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Series $series, Lesson $lesson)
    {
        Storage::delete($lesson->video_path);
        $lesson->delete();
        return $lesson;
    }
}
