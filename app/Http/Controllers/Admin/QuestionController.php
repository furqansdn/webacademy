<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Quiz\Quiz;
use Illuminate\Http\Request;
use App\Models\Quiz\Question;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    public function index(Quiz $quiz)
    {
        return view('admin.quiz.question.index', compact('quiz'));
    }

    public function datatable(Quiz $quiz)
    {
        $data = $quiz->questions;
        $quizID = $quiz->id;
        return DataTables::of($data)
                ->addColumn('action', function($q) use ($quizID){
                    return view('layouts._action',[
                        'url_edit' => route('admin::question.edit',['quiz' => $quizID , 'question' => $q->id]),
                        'url_destroy' => route('admin::question.destroy',['quiz' => $quizID , 'question' => $q->id]),
                        'title' => $q->title
                    ]);
                })
                ->addIndexColumn()->rawColumns(['action'])->make(true);
    }

    public function create(Quiz $quiz)
    {
        $question = new Question();
        return view('admin.quiz.question.form', compact('question', 'quiz'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        $questionImage = '' ;
        if ($request->hasFile('question_image')) {
            $questionImage = request('question_image')->store('/question-image','public');
        }

        $questionOptionCode = ['A','B','C','D'];
        $question = $quiz->questions()->create([
            'question' => $request->question,
            'question_image' => $questionImage,
            'correct_answer' => $request->correct_answer,
            'answer_explanation' => $request->answer_explanation,
        ]);
        for ($i=0; $i < count($request->option_text); $i++) { 
            $question->questionOptions()->create([
                'mark_code' => $questionOptionCode[$i],
                'option_text' => $request->option_text[$i]
            ]);
        }
        return $question;
    }

}
