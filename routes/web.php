<?php

use App\Http\Controllers\Admin\AssetController as AdminAsset;
use App\Http\Controllers\Admin\BorrowItemController as AdminBorrowItem;
use App\Http\Controllers\Admin\CategoryController as AdminCategory;
use App\Http\Controllers\Admin\ConditionContoller as AdminCondition;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\DepartmentController as AdminDepartment;
use App\Http\Controllers\Admin\DivisionController as AdminDivision;
use App\Http\Controllers\Admin\GroupController as AdminGroup;
use App\Http\Controllers\Admin\ItemController as AdminItem;
use App\Http\Controllers\Admin\PositionController as AdminPosition;
use App\Http\Controllers\Admin\RoomController as AdminRoom;
use App\Http\Controllers\Admin\RoomInventroyController as AdminRoomInventory;
use App\Http\Controllers\Admin\ScopeController as AdminScope;
use App\Http\Controllers\Admin\SubCategoryController as AdminSubCategory;
use App\Http\Controllers\Admin\UserAccountController as AdminUserAccount;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\AssetSubmissionController as UserAssetSubmission;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\User\HistoryController as UserHistory;
use App\Http\Controllers\User\ItemController as UserItem;
use App\Http\Controllers\User\LoanController;
use App\Http\Controllers\User\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'do_login'])->name('do-login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware(['role:admin,user'])->group(function () {
    Route::prefix('/')->name('user')->group(function () {
        Route::get('/', [UserDashboard::class, 'index'])->name('.dashboard');
        Route::get('/guide', [UserDashboard::class, 'guide'])->name('.guide');

        Route::prefix('/loan')->name('.loan')->group(function () {
            Route::get('/form', [LoanController::class, 'form'])->name('.form');
            Route::post('/form', [LoanController::class, 'saveForm'])->name('.form.store');
            Route::get('/file-scan/{id}', [LoanController::class, 'fileScan'])->name('.file-scan');
            Route::post('/file-scan/{id}', [LoanController::class, 'store'])->name('.file-scan.store');
            Route::get('/submission/{id}', [LoanController::class, 'submission'])->name('.submission');
            Route::post('/submission/{id}', [LoanController::class, 'submissionStore'])->name('.submission.store');
            Route::get('/submission/{id}/success', [LoanController::class, 'submissionSuccess'])->name('.submission.success');
            Route::get('/cancel/{id}', [LoanController::class, 'cancel'])->name('.cancel');
        });

        Route::prefix('/transactions')->name('.transaction')->group(function () {
            Route::get('/', [TransactionController::class, 'index']);
            Route::get('/payment/{id}', [TransactionController::class, 'payment'])->name('.payment');
            Route::get('/payment/{id}/detail-payment', [TransactionController::class, 'detailPayment'])->name('.detail-payment');
            Route::post('/payment/{id}/pay', [TransactionController::class, 'pay'])->name('.pay');

        });
    });

    Route::get('/picture/{folder}/{filename}', function ($folder, $filename) {
        $path = storage_path("app/private/$folder/$filename");
        if (!file_exists($path)) {
            abort(404);
        }
        return response()->file($path);
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['role:admin'])->group(function () {
    Route::prefix('/admin')->name('admin')->group(function () {
        Route::prefix('/dashboard')->name('.dashboard')->group(function () {
            Route::get('/', [AdminDashboard::class, 'index']);
        });


        Route::get('/picture/{folder}/{filename}', function ($folder, $filename) {
            $path = storage_path("app/private/$folder/$filename");
            if (!file_exists($path)) {
                abort(404);
            }
            return response()->file($path);
        });
    });
});
