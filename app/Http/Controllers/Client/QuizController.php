<?php

namespace App\Http\Controllers\Client;

use Auth;
use App\Models\Quiz\Quiz;
use Illuminate\Http\Request;
use App\Models\Course\Series;
use App\Models\Quiz\Question;
use App\Models\Quiz\QuizProgress;
use App\Http\Controllers\Controller;
use DB;
class QuizController extends Controller
{
    public function index(Series $series)
    {
        $quiz = $series->quizzes;
        return view('client.quiz.quizList',compact('quiz','series'));
    }

    public function quizStart(Series $series, Quiz $quiz)
    {
        $orderId = $quiz->checkLastAttempt();
        $quizId = $quiz->id;
        
        if ($orderId || $orderId > 0) {
            DB::table('user_answers')->where('user_id', Auth::user()->id)
                ->where('question_id', function ($q) use ($quizId) {
                    $q->select('id')->from('questions')->where('quiz_id', $quizId);
                })->delete();
        }

        $orderId++;
        $quiz->quiz_progress()->create([
            'user_id' => Auth::user()->id,
            'status' => 0,
            'time_left' => $quiz->time_limit * 60,
            'order' => $orderId,
            'total_score' => 0
        ]);

        return redirect()->route('client::quiz.continue', ['series' => $series->slug, 'quiz' => $quiz->id]);
        // return $quiz->questions;
    }

    public function quizContinue(Series $series, Quiz $quiz)
    {
        return view('client.quiz.quiz', compact('quiz'));
    }

    public function quizFinish(Quiz $quiz)
    {
        $lastQuizProgress = $quiz->user_quiz[0]->id;
        $quiz_progress = QuizProgress::find($lastQuizProgress);
        $total_score = $this->getScore($quiz);
        $quiz_progress->update([
            'time_left' => 0,
            'status' => 1,  // 1 Menyatakan Quiz Sudah Selesai
            'total_score' => $total_score
        ]);

        return view('client.quiz.quizFinish', compact('quiz_progress'));
    }
    
    public function getQuestion(Quiz $quiz)
    {
        $question = Question::where('quiz_id', $quiz->id)->paginate(1);
        return $question;
    }

    public function userAnswer(Request $request)
    {
        if ($request->ajax()) { 
            $question_id = $request->question;
            $question = Question::find($question_id);
            if ($question->users) {
                $question->users()->detach(Auth::user()->id);
                $question->users()->attach(Auth::user()->id, ['mark_code' => $request->answer]);
            } else {
                $question->users()->attach(Auth::user()->id, ['mark_code' => $request->answer]);
            }

            return $question;
        }
    }

    public function getScore($quiz)
    {
        
        $score = 0 ;
        foreach ($quiz->questions as $value) {
            // Check if user has answer the question
            if (!$value->users->isEmpty()) {
                // check if user answer's match with question correct answer
                if ($value->users[0]->pivot->mark_code == $value->correct_answer) {
                    // Add a score 
                    $score++;
                }
            }
        }
        // Return score
        return $score;
    }

}
