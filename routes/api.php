<?php



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ApplicantController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
});

Route::group([
    'middleware' => 'jwt.auth',
    'prefix' => 'lead'
], function (){
    Route::post('/', [ApplicantController::class, 'store'])->name('lead.store')->middleware('can:create_applicant');
    Route::get('/', [ApplicantController::class, 'index'])->name('lead.index');
    Route::get('/{id}', [ApplicantController::class, 'show'])->name('lead.show');
});
