<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\Admin\ClearanceController as AdminClearanceController;
use App\Http\Controllers\Faculty\ClearanceController as FacultyClearanceController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GoogleAuthController;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\View;
use App\Models\User;
use Faker\Provider\ar_EG\Address;

Route::get('/', function () {
    return view('welcome');
});

// Google Auth Routes
Route::get('auth/google', [GoogleAuthController::class, 'redirectGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleAuthController::class, 'callbackGoogle'])->name('google.callback');

Route::get('/dashboard', function () {
    if (Auth::check()) {
        if (Auth::user()->user_type === 'Admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('faculty.dashboard');
        }
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); 

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
/////////////////////////////////////////////// Redirects If Not Admin or Faculty Middleware ////////////////////////////////////////////////
Route::middleware(['Admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::middleware(['Faculty'])->group(function () {
    Route::get('/faculty', [FacultyController::class, 'dashboard'])->name('faculty.dashboard');
});
/////////////////////////////////////////////// End of Redirects If Not Admin or Faculty Middleware ////////////////////////////////////////////////

/////////////////////////////////////////////// Admin Routes ////////////////////////////////////////////////
Route::middleware(['auth', 'verified', 'Admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/clearances', [AdminController::class, 'clearances'])->name('admin.views.clearances');
    Route::get('/submitted-reports', [AdminController::class, 'submittedReports'])->name('admin.views.submittedReports');
    Route::get('/faculty', [AdminController::class, 'faculty'])->name('admin.views.faculty');
    Route::get('/my-files', [AdminController::class, 'myFiles'])->name('admin.views.myFiles');
    Route::get('/profile', [AdminController::class, 'profileEdit'])->name('admin.profile.edit');

    //////////////////////// Edit Faculty //////////////////////
    Route::get('/faculty/edit/{id}', [AdminController::class, 'getFacultyData'])->name('admin.faculty.getData'); // Get Faculty Data
    Route::post('/faculty/edit', [AdminController::class, 'editFaculty'])->name('admin.faculty.edit'); // Edit Faculty
    Route::delete('/faculty/delete/{id}', [AdminController::class, 'deleteFaculty'])->name('admin.faculty.delete'); // Delete Faculty
    Route::post('/clearance/update', [AdminController::class, 'updateFacultyClearanceUser'])->name('admin.views.update-clearance'); // Update Clearance

    // Clearance Management
    Route::get('/clearance', [AdminClearanceController::class, 'index'])->name('admin.clearance.manage');
    Route::post('/clearance/store', [AdminClearanceController::class, 'store'])->name('admin.clearance.store');
    Route::post('/clearance/share/{id}', [AdminClearanceController::class, 'share'])->name('admin.clearance.share');
    Route::get('/clearance/edit/{id}', [AdminClearanceController::class, 'edit'])->name('admin.clearance.edit');
    Route::post('/clearance/update/{id}', [AdminClearanceController::class, 'update'])->name('admin.clearance.update');
    Route::delete('/clearance/delete/{id}', [AdminClearanceController::class, 'destroy'])->name('admin.clearance.destroy');

    Route::prefix('clearance/{clearanceId}/requirements')->group(function () {
        Route::get('/', [AdminClearanceController::class, 'requirements'])->name('admin.clearance.requirements');
        Route::post('/store', [AdminClearanceController::class, 'storeRequirement'])->name('admin.clearance.requirements.store');
        Route::get('/edit/{requirementId}', [AdminClearanceController::class, 'editRequirement'])->name('admin.clearance.requirements.edit');
        Route::post('/update/{requirementId}', [AdminClearanceController::class, 'updateRequirement'])->name('admin.clearance.requirements.update');
        Route::delete('/delete/{requirementId}', [AdminClearanceController::class, 'destroyRequirement'])->name('admin.clearance.requirements.destroy');
    });
    Route::post('/admin/clearance/share/{id}', [AdminClearanceController::class, 'share'])->name('admin.clearance.share');
    Route::get('/admin/clearance/check', [AdminClearanceController::class, 'checkClearances'])->name('admin.clearance.check');
    

    /////////////////////////////////////////// Shared Fetch Method and Remove Shared Clearance ///////////////////////////////////////////
    Route::get('/admin/clearance/shared', [AdminClearanceController::class, 'shared'])->name('admin.clearance.shared');
    Route::delete('/admin/clearance/shared/{id}', [AdminClearanceController::class, 'removeShared'])->name('admin.clearance.removeShared');
    Route::get('/admin/clearances/{id}', [AdminClearanceController::class, 'approveClearance'])->name('admin.clearances.approve');
    Route::get('/admin/clearances/{id}', [AdminClearanceController::class, 'showUserClearance'])->name('admin.clearances.show');

    /////////////////////////////////////////// User Clearance DetailsSearch ///////////////////////////////////////////
    Route::post('/admin/clearance/feedback/store', [AdminClearanceController::class, 'storeFeedback'])->name('admin.clearance.feedback.store');
    Route::post('/admin/clearance/search', [AdminClearanceController::class, 'search'])->name('admin.clearance.search');
    Route::get('/admin/clearance/search', [AdminClearanceController::class, 'search'])->name('admin.clearance.search');
    Route::get('/admin/admin/clearance/search', [AdminClearanceController::class, 'search'])->name('admin.clearance.search');

    /////////////////////////////////////////// Departments and Programs ///////////////////////////////////////////
    Route::get('/admin/departments', [AdminController::class, 'showCollege'])->name('admin.views.college');
    Route::post('/admin/departments', [AdminController::class, 'storeCollegeDepartment'])->name('admin.departments.store');
    Route::post('/admin/programs', [AdminController::class, 'storeCollegeProgram'])->name('admin.programs.store');
    Route::delete('/admin/programs/{program}', [AdminController::class, 'destroyCollegeProgram'])->name('admin.programs.destroy');
    Route::delete('/admin/admin/departments/{department}', [AdminController::class, 'destroyCollegeDepartment'])->name('admin.departments.destroy');

    /////////////////////////////////////////// Admin Faculty Management Controller ///////////////////////////////////////////
    Route::post('/admin/assign-faculty', [AdminController::class, 'assignFaculty'])->name('admin.assignFaculty');
    Route::post('/admin/admin/assign-faculty', [AdminController::class, 'assignFaculty'])->name('admin.assignFaculty');
    Route::get('/admin/manage-faculty', [AdminController::class, 'manageFaculty'])->name('admin.manageFaculty');
    Route::get('/admin/admin/manage-faculty', [AdminController::class, 'manageFaculty'])->name('admin.manageFaculty');
});


/////////////////////////////////////////////// End of Admin Routes ////////////////////////////////////////////////
/////////////////////////////////////////////// Faculty Routes ////////////////////////////////////////////////
Route::middleware(['auth', 'verified', 'Faculty'])->prefix('faculty')->group(function () {
    Route::get('/dashboard', [FacultyController::class, 'dashboard'])->name('faculty.dashboard');
    Route::get('/clearances', [FacultyController::class, 'clearances'])->name('faculty.views.clearances');
    Route::get('/submitted-reports', [FacultyController::class, 'submittedReports'])->name('faculty.views.submittedReports');
    Route::get('/my-files', [FacultyController::class, 'myFiles'])->name('faculty.views.myFiles');
    Route::get('/test', [FacultyController::class, 'test'])->name('faculty.views.test');

    // Clearance Controls & Routes
    Route::get('/clearances/view-checklists', [FacultyClearanceController::class, 'index'])->name('faculty.clearances.index');
    
    Route::get('/clearances/show/{id}', [FacultyClearanceController::class, 'show'])->name('faculty.clearances.show');
    
    Route::post('/clearances/share/{id}', [FacultyClearanceController::class, 'share'])->name('faculty.clearances.share'); // If needed
    Route::post('/clearances/{id}/get-copy', [FacultyClearanceController::class, 'getCopy'])->name('faculty.clearances.getCopy');
    Route::post('/faculty/clearances/remove-copy/{id}', [FacultyClearanceController::class, 'removeCopy'])->name('faculty.clearances.removeCopy');
    Route::post('/clearances/remove-copy/{id}', [FacultyClearanceController::class, 'removeCopy'])->name('faculty.clearances.removeCopy1');
    Route::post('/clearances/{userClearanceId}/upload/{requirementId}', [FacultyClearanceController::class, 'upload'])->name('faculty.clearances.upload');
    
    Route::delete('/clearances/{sharedClearanceId}/upload/{requirementId}/delete', [FacultyClearanceController::class, 'deleteFile'])->name('faculty.clearances.delete');
    //clearance view files singles
    Route::get('/clearances/{sharedClearanceId}/requirement/{requirementId}/files', [FacultyClearanceController::class, 'getUploadedFiles'])->name('faculty.clearances.getFiles');
    Route::delete('/clearances/{sharedClearanceId}/upload/{requirementId}/delete/{fileId}', [FacultyClearanceController::class, 'deleteSingleFile'])->name('faculty.clearances.deleteSingleFile');
    Route::delete('/faculty/clearances/delete/{sharedClearanceId}/{requirementId}/{fileId}', [FacultyClearanceController::class, 'deleteSingleFile'])->name('faculty.clearances.deleteSingleFile');
}); 
/////////////////////////////////////////////// End of Faculty Routes ////////////////////////////////////////////////

require __DIR__.'/auth.php';