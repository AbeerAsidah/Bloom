<?php

use App\Http\Controllers\EvaluationController;
// use App\Http\Controllers\PassportAuthController;
// use App\Http\Controllers\ReportController;
// use App\Http\Controllers\TransactionController;
// use App\Http\Controllers\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:api')->post('/broadcasting/auth', function () {
//     return Broadcast::auth(request());
// });

// Broadcast::routes(['middleware' => ['auth:api']]);


//Route::get('/create-client', [App\Http\Controllers\PassportAuthController::class, 'createClient']);
Route::post('/save-token', [App\Http\Controllers\NotificationController::class, 'saveToken'])->name('save-token');
Route::post('/send-notification', [App\Http\Controllers\NotificationController::class, 'sendPushNotification'])->name('send.notification');
// Route::post('admin/login',[\App\Http\Controllers\PassportAuthController::class,'adminLogin'])->name('adminLogin');
// Route::get('request_otp', 'API\AuthController@requestOtp');
// Route::post('verify_otp', 'API\AuthController@verifyOtp');


Route::post('/getLink', [\App\Http\Controllers\MeetingController::class,'getLink'])->name('getLink');;

Route::get('/',[\App\Http\Controllers\TypeController::class,'index']);
Route::post('/broadcasting/auth', function () {
    // عرض نتيجة التفويض
    $result = Broadcast::auth(request());
    dd($result); // سيتم عرض النتيجة والتوقف عن التنفيذ
    
    return $result; // لن يتم الوصول إلى هذه النقطة لأن `dd` يوقف التنفيذ
});


Route::group(['middleware' => ['auth:investor-api,user-api,admin-api']], function () {
    
   
//messages
// Route::get('/Messages/test', [\App\Http\Controllers\ChatController::class, 'testGetMessagesQuery']);

// Route::post('/sendMessage', [\App\Http\Controllers\ChatController::class, 'sendMessage']);
// Route::post('/sendMessageInvestor', [\App\Http\Controllers\ChatController::class, 'sendMessageInvestor']);
// Route::post('/sendMessageUser', [\App\Http\Controllers\ChatController::class, 'sendMessageUser']);
// Route::get('/Messages', [\App\Http\Controllers\PusherController::class, 'index']);


//statistics
    Route::get('/monthly-statistics',[\App\Http\Controllers\StatisticController::class,'getMonthlyStatistics1']);
    Route::get('/project-statistics', [\App\Http\Controllers\StatisticController::class, 'getMonthlyProjectStatistics']);
    Route::get('/Report-statistics', [\App\Http\Controllers\StatisticController::class, 'getMonthlyReportStatistics']);


    //Canvas
    Route::prefix("canvas")->group(function (){
        Route::get('show/{project_id}', [\App\Http\Controllers\CanvasController::class, 'show']);

    });


    Route::prefix("Article")->group(function (){
        Route::get('/',[\App\Http\Controllers\ArticleController::class,'index']);
        Route::get('/{id}',[\App\Http\Controllers\ArticleController::class,'show']);

    });

    Route::prefix("Type")->group(function (){
        Route::get('/{id}',[\App\Http\Controllers\TypeController::class,'show']);
        Route::get('/',[\App\Http\Controllers\TypeController::class,'index']);
        Route::get('/showProjectsByType/{id}',[\App\Http\Controllers\TypeController::class,'showProjectsByType']);
      ///
    });

    Route::prefix("Interest")->group(function (){
        Route::get('/',[\App\Http\Controllers\InterestController::class,'index']);
        Route::get('/{id}',[\App\Http\Controllers\InterestController::class,'show']);

    });

    Route::prefix("/{id}/Evaluation")->group(function (){
        Route::get('/', [EvaluationController::class, 'index']);
        Route::post('/', [EvaluationController::class, 'store']);
        Route::post('delete', [EvaluationController::class, 'destroy']);
        Route::get('all', [EvaluationController::class, 'getTotalEvaluationCount']);
    });


    Route::prefix("projects")->group(function (){

        Route::get('/{id}',[\App\Http\Controllers\ProjectController::class,'show']);
        Route::get('Name/{id}', [\App\Http\Controllers\ProjectController::class, 'searchByName']);
        Route::get('Amount/{id}', [\App\Http\Controllers\ProjectController::class, 'searchByAmount']);
        Route::get('downloadFeasibility_study/{id}', [\App\Http\Controllers\ProjectController::class, 'downloadFeasibility_study']);

    });

    Route::prefix("reports")->group(function (){
        Route::get('/{project_id}',[\App\Http\Controllers\ReportController::class,'projectReports']);
    });
});





Route::group(['middleware' => ['auth:investor-api,admin-api']], function () {

    //Project
    Route::prefix("projects")->group(function (){
        Route::get('/',[\App\Http\Controllers\ProjectController::class,'indexPublic']);
    });
});


Route::group(['middleware' => ['auth:investor-api,user-api']], function () {


    Route::get('/{project_id}/specificProjectReport/{report_id}', [\App\Http\Controllers\ReportController::class, 'specificProjectReport']);

    //Investor
    Route::prefix("investors")->group(function (){
        Route::get('/{id}',[\App\Http\Controllers\InvestorController::class,'showProfileByAnother']);
    });
    //user
    Route::prefix("users")->group(function (){
        Route::get('/{id}',[\App\Http\Controllers\UserController::class,'showProfileByAnotherUser']);
    });

    Route::prefix('notification')->group(function () {
        Route::get('/getUserNotifications', [\App\Http\Controllers\NotificationController::class, 'getUserNotifications']);
        Route::get('/ShowUserNotification/{id}', [\App\Http\Controllers\NotificationController::class, 'ShowUserNotification']);

    });

});


Route::group(['middleware' => ['auth:user-api,admin-api']], function () {

    Route::prefix("projects")->group(function (){
        Route::post('delete/{id}',[\App\Http\Controllers\ProjectController::class,'destroy']);

    });
    Route::prefix("Transaction")->group(function (){
        Route::get('/{projectId}', [\App\Http\Controllers\TransactionController::class, 'indexx']);

    });
});




Route::post('admin/login',[\App\Http\Controllers\PassportAuthController::class,'adminLogin'])->name('adminLogin');

Route::group( ['prefix' => 'admin','middleware' => ['auth:admin-api','scopes:admin'] ],function(){
    // authenticated staff routes here
    //Route::get('dashboard',[PassportAuthController::class,'adminDashboard']);
    Route::get('logout',[\App\Http\Controllers\PassportAuthController::class,'adminlogout'])->name('adminLogout');
    Route::post('delete/{id}', [\App\Http\Controllers\PassportAuthController::class, 'destroy']);

    Route::post('update-bank-account-number', [\App\Http\Controllers\PassportAuthController::class, 'updateAdminBankAccountNumber']);


    //Complaint
    Route::prefix("complaints")->group(function (){
        Route::get('/',[\App\Http\Controllers\ComplaintController::class,'index']);
        Route::get('/{id}',[\App\Http\Controllers\ComplaintController::class,'show']);
        Route::post('delete/{id}',[\App\Http\Controllers\ComplaintController::class,'destroyAdmin']);
    });

    Route::prefix("Interest")->group(function (){
        Route::post('/',[\App\Http\Controllers\InterestController::class,'store']);
        Route::post('update/{id}',[\App\Http\Controllers\InterestController::class,'update']);
        Route::post('delete/{id}',[\App\Http\Controllers\InterestController::class,'destroy']);
    });
    //Tracking
    Route::prefix("trackings")->group(function (){

        Route::get('/',[\App\Http\Controllers\TrackingController::class,'index']);
        Route::post('/',[\App\Http\Controllers\TrackingController::class,'store']);
        Route::get('/{id}',[\App\Http\Controllers\TrackingController::class,'show']);
        Route::post('update/{id}',[\App\Http\Controllers\TrackingController::class,'update']);
        Route::post('delete/{id}',[\App\Http\Controllers\TrackingController::class,'destroy']);
    });



    //Investor
    Route::prefix("investors")->group(function (){

        Route::get('/',[\App\Http\Controllers\InvestorController::class,'index']);
        Route::get('/indexVerified',[\App\Http\Controllers\InvestorController::class,'indexVerified']);
        Route::get('showForAdmin/{id}',[\App\Http\Controllers\InvestorController::class,'showForAdmin']);
        Route::post('delete/{id}',[\App\Http\Controllers\InvestorController::class,'destroyAdmin']);
    });



    Route::prefix("Article")->group(function (){
        Route::post('/',[\App\Http\Controllers\ArticleController::class,'store']);
        Route::post('update/{id}',[\App\Http\Controllers\ArticleController::class,'update']);
        Route::post('delete/{id}',[\App\Http\Controllers\ArticleController::class,'destroy']);
    });

    Route::prefix("reports")->group(function (){
        Route::get('/', [\App\Http\Controllers\ReportController::class, 'index']);
        Route::get('/{id}',[\App\Http\Controllers\ReportController::class,'show']);
        Route::get('/{project_id}/{report_id}', [\App\Http\Controllers\ReportController::class, 'specificProjectReportforAdmin']);


    });

    Route::prefix("Type")->group(function (){
        Route::post('/',[\App\Http\Controllers\TypeController::class,'store']);
        Route::post('update/{id}',[\App\Http\Controllers\TypeController::class,'update']);
        Route::post('delete/{id}',[\App\Http\Controllers\TypeController::class,'destroy']);
    });

    Route::prefix("Transaction")->group(function (){
        Route::get('/', [\App\Http\Controllers\TransactionController::class, 'index']);
        Route::get('/review-requests', [\App\Http\Controllers\TransactionController::class,'reviewRequests']);
        Route::get('/review-requests/{id}', [\App\Http\Controllers\TransactionController::class,'reviewRequest']);
        Route::get('/showAccepted', [\App\Http\Controllers\TransactionController::class,'showAcceptedTransactions']);
        Route::get('/{id}',[\App\Http\Controllers\TransactionController::class,'show']);
        Route::post('{id}/approve', [\App\Http\Controllers\TransactionController::class,'approveTransaction']);
        Route::post('/',[\App\Http\Controllers\TransactionController::class,'store']);
        Route::post('update/{id}',[\App\Http\Controllers\TransactionController::class,'update']);
        Route::post('delete/{id}',[\App\Http\Controllers\TransactionController::class,'destroy']);
    });


    //Project
    Route::prefix("projects")->group(function (){
        Route::get('/',[\App\Http\Controllers\ProjectController::class,'indexAdmin']);
        Route::get('acceptProject/{id}',[\App\Http\Controllers\ProjectController::class,'acceptProject']);
    });


    //Communication
    Route::prefix("communications")->group(function (){
        Route::get('/', [\App\Http\Controllers\CommunicationController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\CommunicationController::class, 'show']);
        Route::get('acceptRequest/{id}', [\App\Http\Controllers\CommunicationController::class, 'acceptRequest']);
    });

    Route::prefix("users")->group(function () {

        Route::get('/', [\App\Http\Controllers\UserController::class, 'indexUser']);
        Route::get('/indexVerified', [\App\Http\Controllers\UserController::class, 'indexVerified']);
        Route::get('showForAdmin/{id}', [\App\Http\Controllers\UserController::class, 'showForAdminUser']);
        Route::post('delete/{id}', [\App\Http\Controllers\UserController::class, 'destroyAdmin']);
    });

    Route::prefix('notification')->group(function () {
        Route::post('/notify-user', [\App\Http\Controllers\NotificationController::class, 'notifyUser']);
    });

    //messages
    Route::post('/sendMessage', [\App\Http\Controllers\ChatController::class, 'sendMessage']);
    Route::post('/indexAdmin', [\App\Http\Controllers\ChatController::class, 'index']);
    Route::get('/users-with-unseen-messages', [\App\Http\Controllers\ChatController::class, 'usersWithUnseenMessages']);
    Route::get('/investors-with-unseen-messages', [\App\Http\Controllers\ChatController::class, 'investorsWithUnseenMessages']);

    //Appointments
    Route::prefix("Appointment")->group(function (){
        Route::get('/', [\App\Http\Controllers\AppointmentController::class, 'indexAdmin']);
        Route::post('/store', [\App\Http\Controllers\AppointmentController::class, 'store']);
        Route::post('update/{id}',[\App\Http\Controllers\AppointmentController::class,'update']);
        Route::post('delete/{id}',[\App\Http\Controllers\AppointmentController::class,'destroy']);
    });


        //Meeting
    Route::prefix("Meeting")->group(function (){
        Route::get('/', [\App\Http\Controllers\MeetingController::class, 'indexAdmin']);
    });
});