<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Quiz\Quiz;
use Illuminate\Http\Request;
use App\Models\Course\Lesson;
use App\Models\Course\Series;
use App\Models\Payment\Invoice;
use App\Models\Payment\Payment;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $series = Series::latest()->get();
        $allUser = User::whereHas('roles', function($query){
            $query->where('name', 'client');
        })->count();
        $allSeries = $this->sumTotalSeries();
        $totalPayment = $this->sumTotalPayment();
        $allLecture = $this->sumLecture();
        // dd($payment);
        return view('admin.dashboard.index',compact('series','allUser','totalPayment','allSeries','allLecture'));
    }

    public function getPaymentPerWeeks()
    {
        $payment = Payment::leftJoin('invoices', 'invoices.id','=','payments.invoice_id')
                    ->select(
                        \DB::raw('sum(invoices.amount) as totals'),
                        \DB::raw("DATE_FORMAT(payments.paid_at,'%M') as label")
                    )->groupBy('label')->orderBy('label','DESC')->get();
        return response()->json($payment);
    }

    public function getPopularSeries()
    {
        $popular = Series::leftJoin('series_takens', 'series_takens.series_id','=','series.id')
                    ->select(
                        \DB::raw('count(series_takens.id) as totals'),
                        \DB::raw('series.title as label')
                    )->groupBy('label')->orderBy('label', 'DESC')->take(5)->get();

        return response()->json($popular);
    }

    public function sumTotalPayment()
    {
        return Invoice::whereHas('payment', function($query){
            $query->where('isConfirm', 1);
        })->sum('amount');
    }

    public function sumTotalSeries()
    {
        return Series::count();
    }

    public function sumLecture()
    {
        $course = Lesson::count();
        $quiz = Quiz::count();
        return $course + $quiz;
    }
}
