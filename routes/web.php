<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Models\Course\Series;
use App\Models\Membership\Plan;
use Illuminate\Support\Facades\File;

Route::get('/', function () {
    $series = Series::latest('id')->take(3)->get();
    $plan = Plan::all();
    return view('welcome',compact('series','plan'));
})->name('landingpage');

Auth::routes(['verify' => true]);

Route::group(['prefix' => 'admin', 'as' => 'admin::'], function () {
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');
    Route::resource('/series', 'Admin\SeriesController');
    Route::resource('/series/{series}/lesson', 'Admin\LessonController');
    Route::get('/plan/data','Admin\PlanController@data')->name('plan.data');
    Route::resource('/plan', 'Admin\PlanController');
    Route::get('/user/subscription', 'Admin\SubscriptionController@userSubscription')->name('user.subscription');
    Route::get('/user/subscription/{subscription}/detail', 'Admin\SubscriptionController@userSubscriptionDetail')->name('user.subscription.detail');

    Route::patch('/user/subscription/confirmation/{subscription}', 'Admin\SubscriptionController@confirm')->name('user.subscription.confirm');
    Route::get('/series/{series}/quiz/data', 'Admin\QuizController@datatable')->name('quiz.data');
    Route::resource('/series/{series}/quiz', 'Admin\QuizController');
    Route::get('/quiz/{quiz}/question/data', 'Admin\QuestionController@datatable')->name('question.data');
    Route::resource('/quiz/{quiz}/question', 'Admin\QuestionController');
    Route::get('/user/payment', 'Admin\UserPaymentController@index')->name('user.payment');
    Route::get('/dashboard/data/payment','Admin\DashboardController@getPaymentPerWeeks')->name('dashboard.data.getpayment');
    Route::get('/dashboard/data/popular-series','Admin\DashboardController@getPopularSeries')->name('dashboard.data.popular');
    Route::get('/storage/{path}/', 'Admin\FileController@fileStorageServe')->where(['path' => '.*'])->name('storage.receipt');

});

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/discussion', 'Client\DiscussionController');
Route::resource('/discussion/{discussion}/reply', 'Client\ReplyController');

Route::post('/reply/{reply}/like', 'Client\LikeController@likeIt')->name('reply.like');
Route::delete('/reply/{reply}/unlike', 'Client\LikeController@unlikeIt')->name('reply.unlike');
Route::get('/lesson/completion/{series}', 'Client\SeriesController@courseCompletion')->name('test');

Route::group(['as' => 'client::'], function () {
    Route::get('/course-list', 'Client\SeriesController@courseList')->name('series.list');
    Route::get('/my-course-list', 'Client\SeriesController@myAllCourse')->name('series.mycourse');
    Route::get('/series-preview/{series}', 'Client\SeriesController@show')->name('series.show')->middleware('auth');
    Route::get('/series-learn/{series}/{lesson}', 'Client\SeriesController@learn')->name('series.learning')->middleware(['auth','isSubscribe']);
    Route::post('/series/attach','Client\SeriesController@attachUserSeries')->name('series.attach');
    Route::post('/series/{series}/lesson/{lesson}/complete', 'Client\SeriesController@markComplete')->name('series.lesson.complete');
    // Quiz
    Route::get('/series/{series}/quiz', 'Client\QuizController@index')->name('quiz.list')->middleware('auth');
    Route::get('/series/{series}/quiz/{quiz}/start', 'Client\QuizController@quizStart')->name('quiz.start')->middleware(['auth', 'isSubscribe']);
    Route::get('/series/{series}/quiz/{quiz}', 'Client\QuizController@quizContinue')->name('quiz.continue')->middleware(['auth', 'isSubscribe']);
    Route::get('/quiz/{quiz}/question', 'Client\QuizController@getQuestion')->name('quiz.question');
    Route::post('/quiz/user/answer', 'Client\QuizController@userAnswer')->name('quiz.question.answer');
    Route::get('/quiz/{quiz}/finish', 'Client\QuizController@quizFinish')->name('quiz.question.finish');


    // Subscription
    Route::get('/subscription/plan', 'Client\SubscriptionController@plan')->name('subscription.plan');
    Route::get('/subscription/plan/{plan}/invoice', 'Client\SubscriptionController@generateInvoice')->name('subscription.invoice')->middleware('auth');   
    Route::get('/subscription/checkout/{subscription}', 'Client\SubscriptionController@checkout')->name('subscription.checkout')->middleware('auth');
    Route::get('/subscription/purchase-list', 'Client\SubscriptionController@purchaseList')->name('subscription.purchase.index');
    Route::get('/subscription/purchase-list/data', 'Client\SubscriptionController@purchaseListData')->name('subscription.purchase.data');
    Route::get('/subscription/payment-confirmation', 'Client\SubscriptionController@paymentConfirmation')->name('subscription.paymentConfirmation');
    Route::post('/subscription/plan/{plan}/invoice/proceed', 'Client\SubscriptionController@proceed')->name('subscription.proceed')->middleware('auth');   
    Route::post('/subscription/payment-confirmation', 'Client\SubscriptionController@paymentConfirmationStore')->name('subscription.payment.store');

    // Sertificate
    Route::get('/certificate/{series}', 'Client\SeriesController@downloadCertificate')->name('series.certificate');

});

Route::any('/get-video/{series}/{lesson}', function ($series,$lesson){
    // if (!Auth::user()->isSubscribed()) {
    //     abort(404);
    // }
    $fileContents = Storage::disk('local')->get("public/lesson/{$series}/$lesson");
    $response = Response::make($fileContents,200);
    $response->header('Content_Type', "video/mp4");
    return $response;
})->name('storage.video');