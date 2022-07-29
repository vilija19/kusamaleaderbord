<?php
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\ValidatorController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [LeaderboardController::class,'index'])->name('home.index');
Route::get('/validator/{id}', [ValidatorController::class,'show'])->name('validator.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(config('fortify.middleware', ['web']))->prefix('metamask')->group(function () {
    $limiter = config('fortify.limiters.metamask');

    Route::get('/ethereum/signature', [\App\Http\Controllers\Web3AuthController::class, 'signature'])
        ->name('metamask.signature')
        ->middleware('guest:'.config('fortify.guard'));

    Route::post('/ethereum/authenticate', [\App\Http\Controllers\Web3AuthController::class, 'authenticate'])
        ->middleware(array_filter([
            'guest:'.config('fortify.guard'),
            $limiter ? 'throttle:'.$limiter : null,
        ]))->name('metamask.authenticate');
});

require __DIR__.'/auth.php';
