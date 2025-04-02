<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\LoginUserController;
use App\http\Controllers\JobRequestController;
use App\Http\Controllers\AdminController;

//for login user
Route::get('/', function () {
    return view('pages.admin.login');
})->name('login');
Route::post('/login/user', [LoginUserController::class, 'index'])->name('login.user');
Route::get('/logout', [LoginUserController::class, 'logout'])->name('logout');

// for requestor
Route::middleware(['check.user.type:0', 'load.user.data'])->group(function () {
    Route::get('/requestForm', function () {
        return view('pages.requestor.requestForm');
    })->name('requestForm');
    Route::get('/currentRequest', [JobRequestController::class, 'index'])->name('currentRequest');
    Route::post('saveRequest', [JobRequestController::class, 'saverequest'])->name('saveRequest');
    Route::Post('/requests/{job}/cancel', [JobRequestController::class, 'cancelRequest'])->name('requests.cancel');
});

// For Admin
Route::middleware(['check.user.type:1', 'load.user.data'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/admin/finished', [TechnicianController::class, 'finished'])->name('finished');
    Route::Post('/admin-technician', [AdminController::class, 'SavedTechnician'])->name('admin-technician');
    Route::Post('/admin/remove/technician', [AdminController::class, 'RemoveTechnician'])->name('remove-technician');
    Route::get('/admin/technician', [AdminController::class, 'index'])->name('technician');
    Route::get('/view/technician', [AdminController::class, 'getAllTechnican'])->name('view-technician');
    Route::get('/admin/request', [TechnicianController::class, 'requestor'])->name('admin.request');
    Route::Post('/admin/cancel', [AdminController::class, 'adminCancel'])->name('admin.cancel');
});

//technician
    Route::middleware(['check.user.type:2', 'load.user.data'])->group(function () {
    Route::get('technician/dashboard', [AdminController::class, 'index'])->name('tech.dashboard');
    Route::Post('/technician/{job}/{code}/accept', [TechnicianController::class, 'acceptRequest'])->name('technician.accept');
    Route::get('/technician/request', [TechnicianController::class, 'requestor'])->name('technician.request');
    Route::get('/technician/finished', [TechnicianController::class, 'finished'])->name('technician.finished');
    
    Route::Post('/technician/transfer', [TechnicianController::class, 'Transfer'])->name('technician.transfer');
    Route::Post('technician/done', [TechnicianController::class, 'done'])->name('technician.done');
    // Route::get('/technician/request', [TechnicianController::class, 'requestor'])->name('technician.request');
    // Route::get('/technician/finished', function () {
    //     return view('pages.admin.finished');
    // })->name('technician.finished');

});

