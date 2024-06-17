<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminCourseController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SubmissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::middleware('api')->group(function () {
    Route::prefix('user')->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::post('login', 'login')->name('api.user.login');
            Route::post('register', 'register')->name('api.user.register');
            Route::post('logout', 'logout')->name('api.user.logout');
            Route::post('refresh', 'refresh')->name('api.user.refresh.token');
        });

        Route::middleware('auth:api')->group(function () {
            Route::get('courses',[CourseController::class, "getUserCourses"]);
            Route::prefix('notifications')->controller(NotificationController::class)->group(function() {
                Route::get('get/{id}','show');
                Route::post('maskAsRead', 'maskAsRead');
            });
            Route::prefix('submission')->controller(SubmissionController::class)->group(function () {
                Route::post('store', 'store')->name('api.submission.store');
                Route::post('update/{id}', 'update');
            });
            Route::get("/assignments/{id}", [AssignmentController::class, "get"]);
            Route::prefix('enrollment')->controller(EnrollmentController::class)->group(function () {
                Route::get('get/{studentId}/{courseId}', 'getEnrollment')->name('api.enrollment.get');
                Route::post('store', 'store')->name('api.enrollment.store');
                Route::post('check', 'checkUserIsRegistered')->name('api.enrollment.check');
                Route::get('course/{id}', 'getStudentCourse')->name('api.enrollment.get.student');
            });
            Route::controller(UserProfileController::class)->group(function () {
                Route::put('{id}', 'update');
                Route::put('change-pass/{id}', 'updatePassword');
            });
        });
    });

    Route::prefix('review')->middleware('auth:api')->controller(ReviewController::class)->group(function () {
        Route::post('store', 'store')->name('api.review.store');
    });
});

Route::prefix('user')->group(function () {
    Route::controller(UserProfileController::class)->group(function () {
        Route::get('{id}', 'show');
    });
});

Route::prefix('course')->controller(CourseController::class)->group(function () {
    Route::get("popular", "getCoursePopular")->name('api.course.popular');
    Route::get("review", "getListCourseReviews")->name('api.course.list');
    Route::get("trainer/{id}", "getTrainerCourse");
    Route::get("/", "index")->name('api.course.index');
    Route::get("{id}","show")->name('api.course.show');
    Route::middleware('auth:api') -> group(function () {
        Route::post("", "store")->name('api.course.store');
        Route::put("{id}","update")->name('api.course.update');
        Route::delete("/{id}","destroy")->name('api.course.delete');
    });
});
Route::prefix('review')->controller(ReviewController::class)->group(function () {
    Route::get("course/{id}", "getByCourse")->name('api.review.course');
});

Route::post("/send-contact", [ContactController:: class, 'send'])->name('Contact');

Route::prefix('admin')->group(function () {
    Route::controller(AdminAuthController::class)->group(function () {
        Route::post('/login', 'login');
    });

    Route::middleware(['auth:sanctum', 'auth.admin'])->group(function () {
        Route::controller(AdminController::class)->group(function () {
            Route::get('/total', 'index');
        });

        Route::prefix('course')->controller(AdminCourseController::class)->group(function () {
            Route::get('get', 'index')->name('api.admin.course.list');
            Route::get('get/{id}', 'show')->name('api.admin.course.show');
            Route::put('update/{id}', 'update')->name('api.admin.course.update');
        });

        Route::controller(AdminUserController::class)->group(function () {
            Route::get('user', 'index');
            Route::get('user/trainer/{id}', 'show');
            Route::get('user/trainer/course/{id}', 'getStudentList');
            Route::get('user/student/{id}', 'getStudentDetail');
        });

        Route::controller(AdminAuthController::class)->group(function () {
            Route::post('user/logout', 'logout')->name('api.admin.logout');
        });

        Route::prefix('review')->controller(AdminReviewController::class)->group(function () {
            Route::get('', 'index')->name('api.admin.review.index');
            Route::put('update', 'update')->name('api.admin.review.update');
        });

        Route::get('admin/verify_token', function(Request $request) {
            return response()->json([
                'error' => false,
                'message' => 'Token is valid'
            ]);
        });
    });
});

Route::get('search',[SearchController::class, 'search']);
