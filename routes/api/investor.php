<?php


use App\Http\Controllers\InterestController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\ChatController;

use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('investor/register', [PassportAuthController::class, 'registerInvestor'])->name('registerInvestor');
Route::post('investor/login', [PassportAuthController::class, 'LoginInvestor'])->name('LoginInvestor');
Route::post('verify_otpInv',[PassportAuthController::class,'verifyOtpInv']);

Route::group( ['prefix' =>'investor','middleware' => ['auth:investor-api','scopes:investor'] ],function(){
    // authenticated staff routes here

//    Route::get('dashboard',[PassportAuthController::class, 'userDashboard']);
    Route::get('logout',[PassportAuthController::class,'LogoutInvestor'])->name('LogoutInvestor');

    Route::get('/{project_id}/reports', [ReportController::class, 'showReportsFor_investor']);
    Route::post('/interests', [InterestController::class, 'addInterests']);
    Route::get('/projects/investor-interests', [InterestController::class, 'getProjectsByInvestorInterests']);


//Complaint
    Route::prefix("complaints")->group(function (){

        Route::post('/',[\App\Http\Controllers\ComplaintController::class,'store']);
        Route::post('update/{id}',[\App\Http\Controllers\ComplaintController::class,'update']);
        Route::post('delete/{id}',[\App\Http\Controllers\ComplaintController::class,'destroyInvestor']);
        Route::get('getInvestorComplaints/{id}',[\App\Http\Controllers\ComplaintController::class,'getInvestorComplaints']);
    });



//Investor
    Route::prefix("investors")->group(function (){
        Route::post('update/{id}',[InvestorController::class,'update']);
        Route::post('delete',[InvestorController::class,'destroyInvestor']);
        Route::get('show',[InvestorController::class,'showMyProfile']);

    });




//Communication
    Route::prefix("communications")->group(function (){

        Route::post('/{id}', [CommunicationController::class, 'store']);
    });

    //messages
    Route::post('/sendMessageInvestor', [ChatController::class, 'sendMessageInvestor']);
    Route::post('/indexInvestor', [ChatController::class, 'indexInvestor']);
    Route::get('/admins-with-unseen-messages', [ChatController::class, 'adminWithUnseenMessages']);

    //Appointments
    Route::prefix("Appointment")->group(function (){
        Route::get('/', [\App\Http\Controllers\AppointmentController::class, 'indexInvestor']);
    });



     //Meeting
     Route::prefix("Meeting")->group(function (){
        Route::post('/{id}/{project_id}', [\App\Http\Controllers\MeetingController::class, 'store']);
    });


});







Route::get('/2', function () {
  
    return "abeer ok";
});


// Route::get('/investor1', function () {

//     $investor = Investor::all();

//     return $investor;

// });