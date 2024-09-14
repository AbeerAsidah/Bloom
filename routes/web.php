<?php

use Illuminate\Support\Facades\Route;
use App\Models\Admin;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// //اولا
// Route::get('/migrate', function () {

//     Artisan::call('migrate',['--force' => true]);

//     return "done";

// });
Route::get('/soso', function () {

    Artisan::call('passport:install',[ '--force' => true ]);


    return "done";

});

// // ثانيا
// Route::get('/migrate-fresh', function () {

//     Artisan::call('migrate:fresh',['--seed' => true,'--force' => true]);

//     return "done";

// });

// // ثالثا
// Route::get('/key-generate', function () {

//     Artisan::call('key:generate');
//     return "Key generated successfully.";

// });

// Route::get('/passport-install', function () {

//     Artisan::call('passport:install');
//     return "done";

// });

// Route::get('/passport-client', function () {

//     Artisan::call('passport:client',['--personal' => true]);
//     return "done";

// });

// //hi
// Route::get('/hi', function () {

//     return "done";

// });
// //abeer
// Route::get('/abeerabeer', function () {

//     $admin = Admin::all();

//     return $admin;

// });

// Route::get('/seed', function () {
//     Artisan::call('db:seed --class=investorSeeder');
//     Artisan::call('db:seed --class=AdminSeeder');

//     return 'تم تنفيذ عملية seeding بنجاح.';
// });

// Route::get('/noor_test', function () {


//     return 'noor testing true 02';




// });

Route::get('/cache-clear', function () {
    Artisan::call('cache:clear');
    return 'Cache cleared successfully.';
});

Route::get('/config-clear', function () {
    Artisan::call('config:clear');
    return 'Configuration cache cleared successfully.';
});

Route::get('/route-clear', function () {
    Artisan::call('route:clear');
    return 'Route cache cleared successfully.';
});

Route::get('/view-clear', function () {
    Artisan::call('view:clear');
    return 'View cache cleared successfully.';
});

Route::get('/migrate-fresh', function () {

    Artisan::call('migrate:fresh',['--seed' => true,'--force' => true]);

    return "done";

});
Route::get('/create-client1', function () {

    Artisan::call('passport:client',[
        '--no-interaction'=>true,
        '--name'=>'Tenant Password Grant Client'
            ]);
    return "done";

});