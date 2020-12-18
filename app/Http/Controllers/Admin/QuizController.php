<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Quiz\Quiz;
use Illuminate\Http\Request;
use App\Models\Course\Series;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\QuizRequest;

class QuizController extends Controller
{
    public function index(Series $series)
    {
        return view('admin.quiz.index', compact('series'));
    }

    public function datatable(Series $series)
    {
        $quiz = $series->quizzes;
        $seriesSlug = $series->slug;
        return DataTables::of($quiz)
                ->addColumn('action', function($q) use ($seriesSlug){
                    return view('layouts._action',[
                        'url_edit' => route('admin::quiz.edit',['series' => $seriesSlug , 'quiz' => $q->id]),
                        'url_destroy' => route('admin::quiz.destroy',['series' => $seriesSlug , 'quiz' => $q->id]),
                        'title' => $q->title
                    ]);
                })
                ->addColumn('limit', function($q) {
                    return $q->time_limit . ' Minutes';
                })
                ->addColumn('addQuestion', function($q) use ($seriesSlug) {
                    return '<button class="btn btn-outline-primary modal-show">Add Question</button>';
                })
                ->addIndexColumn()->rawColumns(['action'])->make(true);
    }

    public function create(Series $series)
    {
        $quiz = new Quiz();
        return view('admin.quiz.form',compact('quiz','series'));
    }

    public function store(QuizRequest $request, Series $series)
    {
        $is_premium = $request->is_premium ? 1 : 0;
        
        $data = $series->quizzes()->create([
            'title' => $request->title,
            'score_per_question' => $request->score_per_question,
            'time_limit' => $request->time_limit,
            'is_premium' => $request->is_premium,
            'description' => $request->description,
        ]);

        return $data;
    }

    public function edit(Series $series, Quiz $quiz)
    {
        return view('admin.quiz.form', compact('series', 'quiz'));
    }

    public function update(QuizRequest $request, Series $series, Quiz $quiz)
    {
        $quiz->update($request->all());
        return $quiz;
    }

    public function destroy(Series $series, Quiz $quiz)
    {   
        $quiz->delete();
        return response()->json([
            'message' => 'Quiz Berhasil Dihapus'
        ], 200);
    }
}
