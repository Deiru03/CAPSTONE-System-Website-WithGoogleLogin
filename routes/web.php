<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\Admin\ClearanceController as AdminClearanceController;
use App\Http\Controllers\Faculty\ClearanceController as FacultyClearanceController;
use App\Http\Controllers\Admin\CampusController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\OptimizationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\GenerateReports;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\UploadedClearance;
use Faker\Provider\ar_EG\Address;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\AboutController;

Route::get('/', function () {
    return view('welcome');
});
/////////////////////////////////////////////// File View Route ////////////////////////////////////////////////
// General file view route
Route::get('/file-view/{path}', function($path) {
    $fullPath = storage_path('app/public/' . $path);
    
    if (!File::exists($fullPath)) {
        abort(404);
    }
    
    return response()->file($fullPath, [
        'Content-Type' => File::mimeType($fullPath),
        'Content-Disposition' => 'inline; filename="' . basename($path) . '"'
    ]);
})->where('path', '.*')->middleware('auth');

// Profile pictures route 
Route::get('/profile_pictures/{path}', function($path) {
    $fullPath = storage_path('app/public/profile_pictures/' . $path);
    
    if (!File::exists($fullPath)) {
        // Return default profile picture if requested one doesn't exist
        $fullPath = public_path('images/default-profile.png');
        if (!File::exists($fullPath)) {
            abort(404);
        }
    }
    
    return response()->file($fullPath, [
        'Content-Type' => File::mimeType($fullPath),
        'Content-Disposition' => 'inline; filename="' . basename($path) . '"'
    ]);
})->where('path', '.*')->middleware('auth');
/////////////////////////////////////////////// End of File View Route ////////////////////////////////////////////////


// Google Auth Routes
Route::get('auth/google', [GoogleAuthController::class, 'redirectGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleAuthController::class, 'callbackGoogle'])->name('google.callback');

Route::get('/homepage', function () {
    if (Auth::check()) {
        if (Auth::user()->user_type === 'Admin') {
            return redirect()->route('admin.home');
        } else {
            return redirect()->route('faculty.home');
        }
    }
    return view('homepage');
})->middleware(['auth', 'verified'])->name('homepage'); 


Route::get('/dashboard', function () {
    if (Auth::check()) {
        if (Auth::user()->user_type === 'Admin' ||
            Auth::user()->user_type === 'Dean' ||
            Auth::user()->user_type === 'Program-Head') {
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
Route::middleware(['Admin', 'Dean', 'Program-Head'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/homepage', [AdminController::class, 'home'])->name('admin.home');
});

Route::middleware(['Faculty'])->group(function () {
    Route::get('/faculty', [FacultyController::class, 'dashboard'])->name('faculty.dashboard');
    Route::get('/faculty/homepage', [FacultyController::class, 'home'])->name('faculty.home');
});

Route::middleware('auth')->group(function () {
    Route::get('/notifications/unread', [NotificationController::class, 'getUnreadNotifications']);
});
/////////////////////////////////////////////// End of Redirects If Not Admin or Faculty Middleware ////////////////////////////////////////////////

/////////////////////////////////////////////// Optimization Routes ////////////////////////////////////////////////
Route::get('/optimize/clear-cache', [OptimizationController::class, 'clearCache'])->name('optimize.clearCache');
Route::get('/optimize/prune-reports', [OptimizationController::class, 'pruneReports'])->name('optimize.pruneReports');
//--------------------------------------------------------------------------------------------------------------------//
/////////////////////////////////////////////// New Uploads Count Route ////////////////////////////////////////////////
Route::get('/api/new-uploads-per-user', function () {
    $lastCheck = session('last_clearance_check', now()->subDay());
    $newUploads = UploadedClearance::newUploadsPerUser($lastCheck);
    return response()->json($newUploads);
});


Route::middleware('auth')->group(function () {
   Route::get('/notifications/unread', [NotificationController::class, 'getUnreadNotifications']);
   Route::post('/notifications/{notificationId}/mark-as-read', [NotificationController::class, 'markAsRead']);
});

/////////////////////////////////////////////// Role Switch Route ////////////////////////////////////////////////
Route::post('/switch-role', [ProfileController::class, 'switchRole'])->name('switchRole');

/////////////////////////////////////////////// DomPDF Routes ////////////////////////////////////////////////
Route::get('/admin/generate-report', [AdminController::class, 'generateReport'])->name('admin.generateReport');
Route::post('/admin/faculty-report/generate', [AdminController::class, 'generateFacultyReport'])->name('admin.facultyReport.generate');
Route::get('/admin/faculty-report/managed', [AdminController::class, 'generateManagedFacultyReport'])->name('admin.facultyReport.managed');
Route::get('/admin/clearance/{id}/report', [AdminClearanceController::class, 'generateChecklistInfo'])->name('admin.clearance.report');
Route::get('/admin/reports', [GenerateReports::class, 'showReportForm'])->name('admin.reports.show');
Route::post('/admin/reports/generate', [GenerateReports::class, 'generateSubmittedReport'])->name('admin.reports.generateSubmittedReport');
Route::get('/admin/clearance/{id}/print', [AdminClearanceController::class, 'printChecklist'])->name('admin.clearance.print');
Route::get('/admin/clearance/{clearanceId}/print/{userId}', [AdminClearanceController::class, 'printChecklist'])->name('admin.clearance.print');

/////////////////////////////////////////////// Register Routes ////////////////////////////////////////////////
Route::get('/departments/{campusId}', [RegisteredUserController::class, 'getDepartments']);
Route::get('/programs/{departmentId}', [RegisteredUserController::class, 'getPrograms']);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////// Admin Routes ////////////////////////////////////////////////
Route::middleware(['auth', 'verified', 'Admin', 'Dean', 'Program-Head'])->prefix('admin')->group(function () {
    Route::get('/homepage', [AdminController::class, 'home'])->name('admin.home');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/clearances_view', [AdminController::class, 'clearances'])->name('admin.views.clearances');
    Route::get('/submitted-reports', [AdminController::class, 'submittedReports'])->name('admin.views.submittedReports');
    Route::get('/faculty', [AdminController::class, 'faculty'])->name('admin.views.faculty');
    Route::get('/my-files', [AdminController::class, 'myFiles'])->name('admin.views.myFiles');
    Route::get('/action-reports', [AdminController::class, 'adminActionReports'])->name('admin.views.actionReports');
    Route::get('/archive', [AdminController::class, 'archive'])->name('admin.views.archive');
    Route::get('/profile', [AdminController::class, 'profileEdit'])->name('admin.profile.edit');
    Route::get('/admin-id-management', [AdminController::class, 'adminIdManagement'])->name('admin.adminIdManagement');

    ///////////////////// Admin ID Management /////////////////////
    Route::post('/admin-id-management', [AdminController::class, 'createAdminId'])->name('admin.createAdminId');
    Route::delete('/delete-admin-id/{id}', [AdminController::class, 'deleteAdminId'])->name('admin.deleteAdminId');
    Route::post('/create-program-head-dean-id', [AdminController::class, 'createProgramHeadDeanId'])->name('admin.createProgramHeadDeanId');
    // Route::delete('/delete-program-head-dean-id/{id}', [AdminController::class, 'deleteProgramHeadDeanId'])->name('admin.deleteProgramHeadDeanId');
    Route::delete('/admin/program-head-dean-id/{id}', [AdminController::class, 'deleteProgramHeadDeanId'])->name('admin.deleteProgramHeadDeanId');

    //////////////////////// Edit Faculty.view//////////////////////
    Route::get('/faculty/edit/{id}', [AdminController::class, 'getFacultyData'])->name('admin.faculty.getData'); // Get Faculty Data
    Route::post('/faculty/edit', [AdminController::class, 'editFaculty'])->name('admin.faculty.edit'); // Edit Faculty
    Route::delete('/faculty/delete/{id}', [AdminController::class, 'deleteFaculty'])->name('admin.faculty.delete'); // Delete Faculty
    // Route::post('/clearance/update', [AdminController::class, 'updateFacultyClearanceUser'])->name('admin.views.update-clearance'); // Update Clearance
 
    //////////////////////// Clearance.view Update Users Clearances //////////////////////
    Route::post('/admin/clearance/update', [AdminController::class, 'updateUserClearance'])->name('admin.clearanceUserUpdate');
    Route::get('/admin/clearances', [AdminClearanceController::class, 'showClearances'])->name('admin.clearances');
    Route::post('/admin/clearance/assign', [AdminClearanceController::class, 'assignClearanceCopy'])->name('admin.clearance.assign');

    // Clearance Management
    Route::middleware(['Admin'])->group(function () {
        Route::get('/clearance_manage', [AdminClearanceController::class, 'index'])->name('admin.clearance.manage');
        Route::post('/clearance/store', [AdminClearanceController::class, 'store'])->name('admin.clearance.store');
        Route::post('/clearance/share/{id}', [AdminClearanceController::class, 'share'])->name('admin.clearance.share');
        Route::get('/clearance/edit/{id}', [AdminClearanceController::class, 'edit'])->name('admin.clearance.edit');
        Route::post('/clearance/update/{id}', [AdminClearanceController::class, 'update'])->name('admin.clearance.update');
        Route::delete('/clearance/delete/{id}', [AdminClearanceController::class, 'destroy'])->name('admin.clearance.destroy');
        Route::get('/clearance/{id}/details', [AdminClearanceController::class, 'getClearanceDetails'])->name('admin.clearance.details');
        Route::get('/clearance/all', [AdminClearanceController::class, 'getAllClearances'])->name('admin.clearance.all');
    });

    Route::prefix('clearance/{clearanceId}/requirements')->group(function () {
        Route::get('/', [AdminClearanceController::class, 'requirements'])->name('admin.clearance.requirements');
        Route::post('/store', [AdminClearanceController::class, 'storeRequirement'])->name('admin.clearance.requirements.store');
        Route::get('/edit/{requirementId}', [AdminClearanceController::class, 'editRequirement'])->name('admin.clearance.requirements.edit');
        Route::post('/update/{requirementId}', [AdminClearanceController::class, 'updateRequirement'])->name('admin.clearance.requirements.update');
        Route::delete('/delete/{requirementId}', [AdminClearanceController::class, 'destroyRequirement'])->name('admin.clearance.requirements.destroy');
    });
    Route::post('/admin/clearance/share/{id}', [AdminClearanceController::class, 'share'])->name('admin.clearance.share');
    Route::get('/admin/clearance/check', [AdminClearanceController::class, 'checkClearances'])->name('admin.clearance.check');
    
    ////////////////////////////////////////////// Archive Controller /////////////////////////////////////////////////
    Route::post('/admin/archive/delete', [AdminController::class, 'deleteArchivedFile'])->name('admin.archive.delete');

    /////////////////////////////////////////// Shared Fetch Method and Remove Shared Clearance ///////////////////////////////////////////
    Route::get('/admin/clearance/shared', [AdminClearanceController::class, 'shared'])->name('admin.clearance.shared');
    Route::delete('/admin/clearance/shared/{id}', [AdminClearanceController::class, 'removeShared'])->name('admin.clearance.removeShared');
    Route::get('/admin/clearances/{id}', [AdminClearanceController::class, 'approveClearance'])->name('admin.clearances.approve');
    Route::get('/admin/clearances/{id}', [AdminClearanceController::class, 'showUserClearance'])->name('admin.clearances.show');
    ////////////////////////////// USERS Clearance Reset ||||| Archiving Route and Methods//////////////////////////////
    Route::post('/admin/clearance/reset-selected', [AdminClearanceController::class, 'resetSelected'])->name('admin.clearance.resetSelected');
    Route::post('/admin/clearance/reset', [AdminClearanceController::class, 'resetUserClearances'])->name('admin.clearance.reset');
    Route::post('/admin/clearance/reset/{userId}', [AdminClearanceController::class, 'resetSpecificUserClearance'])->name('admin.clearance.resetSpecific');
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
    Route::post('/admin/programs/multiple', [AdminController::class, 'storeMultipleCollegePrograms'])->name('admin.programs.storeMultiple');
    Route::get('/admin/department/{id}/edit', [AdminController::class, 'editDepartment'])->name('admin.editDepartment');
    Route::put('/admin/department/{id}', [AdminController::class, 'updateDepartment'])->name('admin.updateDepartment');

    /////////////////////////////////////////// Admin Faculty Management Controller ///////////////////////////////////////////
    Route::post('/admin/assign-faculty', [AdminController::class, 'assignFaculty'])->name('admin.assignFaculty');
    Route::post('/admin/admin/assign-faculty', [AdminController::class, 'assignFaculty'])->name('admin.assignFaculty');
    Route::get('/admin/manage-faculty', [AdminController::class, 'manageFaculty'])->name('admin.manageFaculty');
    Route::get('/admin/admin/manage-faculty', [AdminController::class, 'manageFaculty'])->name('admin.manageFaculty');

    /////////////////////////////////////////// Campus Management ///////////////////////////////////////////
    Route::get('/campuses', [CampusController::class, 'viewCampuses'])->name('admin.views.campuses');
    Route::post('/campuses', [CampusController::class, 'store'])->name('admin.campuses.store');
    Route::match(['get', 'put'], '/campuses/{campus}', [CampusController::class, 'update'])->name('admin.campuses.update');
    Route::delete('/campuses/{campus}', [CampusController::class, 'destroy'])->name('admin.campuses.destroy');

});
/////////////////////////////////////////////// End of Admin Routes ////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////// Faculty Routes ////////////////////////////////////////////////
Route::middleware(['auth', 'verified', 'Faculty'])->prefix('faculty')->group(function () {
    Route::get('/homepage', [FacultyController::class, 'home'])->name('faculty.home');
    Route::get('/dashboard', [FacultyController::class, 'dashboard'])->name('faculty.dashboard');
    Route::get('/clearances', [FacultyController::class, 'clearances'])->name('faculty.views.clearances');
    Route::get('/submitted-reports', [FacultyController::class, 'submittedReports'])->name('faculty.views.submittedReports');
    Route::get('/my-files', [FacultyController::class, 'myFiles'])->name('faculty.views.myFiles');
    Route::get('/archive', [FacultyController::class, 'archive'])->name('faculty.views.archive');
    Route::get('/test', [FacultyController::class, 'test'])->name('faculty.views.test');

    //////////////////////// DomPDF  Clearance Slip //////////////////////
    Route::get('/faculty/clearance-report', [FacultyController::class, 'generateClearanceReport'])->name('faculty.generateClearanceReport');
    Route::get('/faculty/clearance-checklist/{id}', [FacultyController::class, 'generateChecklist'])->name('faculty.clearanceChecklist');

    // Clearance Controls & Routes
    Route::get('/clearances/view-checklists', [FacultyClearanceController::class, 'index'])->name('faculty.clearances.index');
    
    Route::get('/clearances/show/{id}', [FacultyClearanceController::class, 'show'])->name('faculty.clearances.show');
    
    Route::post('/clearances/share/{id}', [FacultyClearanceController::class, 'share'])->name('faculty.clearances.share'); // If needed
    Route::post('/clearances/{id}/get-copy', [FacultyClearanceController::class, 'getCopy'])->name('faculty.clearances.getCopy');
    Route::post('/clearances/remove-copy/{id}', [FacultyClearanceController::class, 'removeCopy'])->name('faculty.clearances.removeCopy1');
    Route::post('/clearances/{userClearanceId}/upload/{requirementId}', [FacultyClearanceController::class, 'upload'])->name('faculty.clearances.upload');
    
    Route::delete('/clearances/{sharedClearanceId}/upload/{requirementId}/delete', [FacultyClearanceController::class, 'deleteFile'])->name('faculty.clearances.delete');
    //clearance view files singles
    Route::get('/clearances/{sharedClearanceId}/requirement/{requirementId}/files', [FacultyClearanceController::class, 'getUploadedFiles'])->name('faculty.clearances.getFiles');
    Route::delete('/clearances/{sharedClearanceId}/upload/{requirementId}/delete/{fileId}', [FacultyClearanceController::class, 'deleteSingleFile'])->name('faculty.clearances.deleteSingleFile');
    Route::delete('/faculty/clearances/delete/{sharedClearanceId}/{requirementId}/{fileId}', [FacultyClearanceController::class, 'deleteSingleFile'])->name('faculty.clearances.deleteSingleFile');
}); 
/////////////////////////////////////////////// End of Faculty Routes ////////////////////////////////////////////////

Route::get('/about-us', [AboutController::class, 'index'])->name('about-us');

require __DIR__.'/auth.php';