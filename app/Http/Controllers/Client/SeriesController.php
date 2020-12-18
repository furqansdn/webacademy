<?php

namespace App\Http\Controllers\Client;

use Auth;
use PDF;
use Illuminate\Http\Request;
use App\Models\Course\Lesson;
use App\Models\Course\Series;
use App\Http\Controllers\Controller;
use App\Http\Resources\SeriesResource;


class SeriesController extends Controller
{
    public function courseList()
    {
        $series = SeriesResource::collection(Series::latest()->get());
        return view('client.series.list', compact('series'));
    }

    public function show(Series $series)
    {
        $series = new SeriesResource($series);
        return view('client.series.show',compact('series'));
    }

    public function learn(Series $series, Lesson $lesson)
    {
        $series = new SeriesResource($series);
        if (!Auth::user()->isSeriesTaken($series->slug)) {
            $this->attachUserSeries($series->id);
        }
        
        return view('client.series.learn', compact('series','lesson'));
    }

    public function attachUserSeries($seriesId)
    {
        $data = Auth::user()->series()->attach($seriesId);
    }

    public function markComplete(Series $series, Lesson $lesson)
    {
        if (!Auth::user()->isLessonComplete($lesson->id)) {
            Auth::user()->progress()->attach($lesson->id);
        }
        if (!$lesson->getNextLesson()) {
            return redirect()->back();
        }
        return redirect()->route('client::series.learning', [$series->slug, $lesson->getNextLesson()->id]);
    }

    public function courseCompletion(Series $series)
    {
        $course_progress = $series->userProgress();
        $sumLesson = $series->countLesson();
        $countLecture = $series->countLecture();

        $progress = ($course_progress/$countLecture) *100;
        return response()->json([
            'course_progress' => $course_progress,
            'sumLesson' => $sumLesson,
            'countQuiz' => $countLecture,
            'progress' => number_format($progress,2,'.','')
        ]);
    }

    public function downloadCertificate(Series $series)
    {
       $pdf = PDF::loadView('client.pdf.pdf',compact('series'))->setPaper('a4', 'landscape');
       $pdfName = 'certificate-of-'.$series->slug.':'.Auth::user()->name;
       return $pdf->stream($pdfName);
    // return view('client.pdf.pdf', compact('series'));
    }

    public function myAllCourse()
    {
        $latestcourse = Auth::user()->series()
                            ->orderBy('series_takens.created_at', 'DESC')
                            ->get();
        
        return view('client.series.myCourse', compact('latestcourse'));
    }

}
