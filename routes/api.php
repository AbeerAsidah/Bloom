<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/link-storage', function () {

    Artisan::call('storage:link',[ '--force' => true ]);


});




Route::get('/migrate-fresh', function () {
    Artisan::call('migrate:fresh',[ '--seed' => true, '--force' => true ]);
    return "done";
});

Route::get('/migrate', function () {
    Artisan::call('migrate',['--force' => true ]);
    return "done";
});



Route::get('/seed', function () {
    Artisan::call('db:seed --class=investorSeeder');
    Artisan::call('db:seed --class=AdminSeeder');

    return 'تم تنفيذ عملية seeding بنجاح.';
});


Route::get('/noor', function () {

    return "abeer ok";
});




Route::get('/run-passport-install', function () {
    Artisan::call('passport:install');
    return "done ok";
});

Route::get('/run-passport-keys-force', function () {
    Artisan::call('passport:keys', [
        '--force' => true,
    ]);
    return Artisan::output();
});
//pre
Route::get('/set-storage-permissions', function () {
    $exitCode = 0;
    $output = '';

    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $output = 'Permission changes are not applicable for Windows.';
    } else {
        $exitCode = shell_exec('chmod -R 0777 ' . escapeshellarg(storage_path()));
        $output = 'Permissions changed successfully.';
    }

    return response()->json([
        'exitCode' => $exitCode,
        'output' => $output,
    ]);
});

Route::get('/commands-list', function () {
    // Execute the artisan command to list all available commands
    Artisan::call('list');

    // Get the output of the command
    $output = Artisan::output();

    // Return the output as the response
    return "<pre>$output</pre>";
});


Route::get('/check-passport', function () {
    try {
        // Create a new process to execute the command
        $process = new Process(['composer', 'show', 'laravel/passport']);

        // Start the process
        $process->start();

        // Wait for the process to finish (maximum 60 seconds)
        $process->wait();

        // Check if the process ended successfully
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // Get the output of the command
        $output = $process->getOutput();

        return "<pre>$output</pre>";
    } catch (ProcessFailedException $exception) {
        return "Error executing command: " . $exception->getMessage();
    }
});


