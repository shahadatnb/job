<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MenuController;

use App\Http\Controllers\SignatureController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\EmploymentController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\SkillConrtoller;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\ApplicantResultController;
use App\Http\Controllers\EduBoardController;
use App\Http\Controllers\EduLevelGroupController;
use App\Http\Controllers\EduGroupController;
use App\Http\Controllers\LanguageProficiencyController;
use App\Http\Controllers\ReferencesController;
use App\Http\Controllers\DepartmentController;

use App\Http\Controllers\SMS\SmsContactController;
use App\Http\Controllers\SMS\SmsLogController;
use App\Http\Controllers\SMS\SmsTemplateController;
use App\Http\Controllers\SMS\SMSController;

use App\Http\Controllers\TaxonomyController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\JobController;

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

Route::get('/', [HomeController::class,'homepage'])->name('/');
Route::get('/page/{slug}', [HomeController::class,'page'])->name('page');
Route::get('/job_detail/{id}', [JobApplicationController::class,'job_detail'])->name('job.job_detail');
Route::post('/job_apply', [JobApplicationController::class,'apply'])->name('job.apply');
Route::get('/set_session', [JobApplicationController::class,'set_session'])->name('job.set_session');
Route::get('applicant/get_edu_group', [EducationController::class, 'edu_group'])->name('applicant.education.group');

Route::prefix(config('app.admin_prefix','admin'))->group(function() {
    //Auth::routes(['register' => false]);//['verify'=> false]
});

Route::get('/dashboard', function () {
    return redirect()->route('applicant.dashboard');
});

Route::get('/admin_dashboard', function () {
    return redirect()->route('home');
});

Route::group(['prefix'=>'applicant','middleware'=>'auth:applicant'], function(){  

    Route::get('/', [ApplicantController::class,'index'])->name('applicant.dashboard');
    Route::get('/profile', [ApplicantController::class,'profile'])->name('applicant.profile');
    Route::get('/editProfile', [ApplicantController::class,'editProfile'])->name('applicant.editProfile');
    Route::post('/updateProfile', [ApplicantController::class,'updateProfile'])->name('applicant.updateProfile');
    Route::post('/chengePassword', [ApplicantController::class,'chengePassword'])->name('applicant.chengePassword');
    Route::post('/updatePhoto', [ApplicantController::class,'updatePhoto'])->name('applicant.photo.update');
    Route::post('/updateSignature', [ApplicantController::class,'updateSignature'])->name('applicant.signature.update');
    Route::post('/updateAddress', [ApplicantController::class,'updateAddress'])->name('applicant.address.update');
    Route::post('/updateCareer', [ApplicantController::class,'updateCareer'])->name('applicant.career.update');
    Route::post('/updateOther', [ApplicantController::class,'updateOther'])->name('applicant.other.update');
    Route::get('/view_cv', [ApplicantController::class,'view_cv'])->name('applicant.view_cv');
    Route::get('/applied_jobs', [ApplicantController::class,'applied_jobs'])->name('applicant.applied_jobs');

    Route::post('education_store', [EducationController::class, 'store'])->name('applicant.education.store');
    Route::get('education_edit', [EducationController::class, 'edit'])->name('applicant.education.edit');
    Route::post('education_update', [EducationController::class, 'update'])->name('applicant.education.update');
    Route::post('education_destroy', [EducationController::class, 'destroy'])->name('applicant.education.destroy');

    Route::post('certification_store', [CertificationController::class, 'store'])->name('applicant.certification.store');
    Route::get('certification_edit', [CertificationController::class, 'edit'])->name('applicant.certification.edit');
    Route::post('certification_update', [CertificationController::class, 'update'])->name('applicant.certification.update');
    Route::post('certification_destroy', [CertificationController::class, 'destroy'])->name('applicant.certification.destroy');

    Route::post('experience_store', [EmploymentController::class, 'store'])->name('applicant.experience.store');
    Route::get('experience_edit', [EmploymentController::class, 'edit'])->name('applicant.experience.edit');
    Route::post('experience_update', [EmploymentController::class, 'update'])->name('applicant.experience.update');
    Route::post('experience_destroy', [EmploymentController::class, 'destroy'])->name('applicant.experience.destroy');

    Route::post('training_store', [TrainingController::class, 'store'])->name('applicant.training.store');
    Route::get('training_edit', [TrainingController::class, 'edit'])->name('applicant.training.edit');
    Route::post('training_update', [TrainingController::class, 'update'])->name('applicant.training.update');
    Route::post('training_destroy', [TrainingController::class, 'destroy'])->name('applicant.training.destroy');

    Route::post('language_store', [LanguageProficiencyController::class, 'store'])->name('applicant.language.store');
    Route::get('language_edit', [LanguageProficiencyController::class, 'edit'])->name('applicant.language.edit');
    Route::post('language_update', [LanguageProficiencyController::class, 'update'])->name('applicant.language.update');
    Route::post('language_destroy', [LanguageProficiencyController::class, 'destroy'])->name('applicant.language.destroy');

    Route::post('reference_store', [ReferencesController::class, 'store'])->name('applicant.reference.store');
    Route::get('reference_edit', [ReferencesController::class, 'edit'])->name('applicant.reference.edit');
    Route::post('reference_update', [ReferencesController::class, 'update'])->name('applicant.reference.update');
    Route::post('reference_destroy', [ReferencesController::class, 'destroy'])->name('applicant.reference.destroy');

    Route::post('skill_store', [SkillConrtoller::class, 'store'])->name('applicant.skill.store');
    Route::post('skill_destroy', [SkillConrtoller::class, 'destroy'])->name('applicant.skill.destroy');
    Route::get('skill_list', [SkillConrtoller::class, 'list'])->name('applicant.skill.list');
});

Route::group(['prefix'=>config('app.admin_prefix','admin'),'middleware'=>'auth'], function(){  

    Route::get('/home', [AdminController::class,'home'])->name('home');
    Route::get('/', [AdminController::class,'index'])->name('dashboard');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('data/summary', [DashboardController::class,'summary'])->name('summary');
        Route::get('data/applications-monthly', [DashboardController::class,'applicationsMonthly'])->name('applications.monthly');
        Route::get('data/applications-by-status', [DashboardController::class,'applicationsByStatus'])->name('applications.status');
        Route::get('data/applicant-gender', [DashboardController::class,'applicantGender'])->name('applicants.gender');
        Route::get('data/top-jobs', [DashboardController::class,'topJobs'])->name('top-jobs');
        Route::get('data/recent-applications', [DashboardController::class,'recentApplications'])->name('recent.applications');
        Route::get('data/recent-applicants', [DashboardController::class,'recentApplicants'])->name('recent.applicants');
    });
    Route::get('/profile', [UsersController::class,'profile'])->name('profile');
    Route::get('/editProfile', [UsersController::class,'editProfile'])->name('editProfile');
    Route::post('/updateProfile', [UsersController::class,'updateProfile'])->name('updateProfile');
    Route::post('/chengePassword', [UsersController::class,'chengePassword'])->name('chengePassword');

    //Route::resource('unit', UnitController::class);
    Route::delete('/applicants/destroy/{applicant}', [ApplicantController::class,'destroy'])->name('applicant.destroy');
    Route::get('/applicants/export', [ApplicantController::class,'export'])->name('applicant.export');
    Route::get('/applicants/{applicant}/edit', [ApplicantController::class,'edit'])->name('applicant.edit');
    Route::put('/applicants/{applicant}', [ApplicantController::class,'update'])->name('applicant.update');
    Route::get('/applicants/{applicant}', [ApplicantController::class,'show'])->name('applicant.show');
    Route::get('/applicants', [ApplicantController::class,'applicants'])->name('applicant.index');
    Route::get('/job/application', [JobApplicationController::class,'application'])->name('job.application');
    Route::get('/job/application/export', [JobApplicationController::class,'export'])->name('job.application.export');
    Route::post('/job/application_status', [JobApplicationController::class,'application_status'])->name('job.application_status');
    
    Route::get('/job/result_entry', [ApplicantResultController::class,'result_entry'])->name('job.result_entry');
    Route::post('/job/result_save', [ApplicantResultController::class,'result_save'])->name('job.result_save');
    
    Route::resource('job', JobController::class);
    Route::resource('designation', DesignationController::class);
    Route::resource('department', DepartmentController::class);
    Route::resource('eduLevelGroup', EduLevelGroupController::class);
    Route::resource('eduBoard', EduBoardController::class);
    Route::resource('eduGroup', EduGroupController::class);
    Route::post('signature_add', [SignatureController::class, 'add'])->name('signature.add');
    Route::post('signature_delete/{id}', [SignatureController::class, 'delete'])->name('signature.delete');
    Route::post('signature_serial', [SignatureController::class, 'serial'])->name('signature.serial');
    Route::resource('signature', SignatureController::class);
});

Route::get('/childLocation', [LocationController::class,'childLocation'])->name('childLocation');

Route::group(['prefix'=>config('app.admin_prefix','admin'),'middleware'=> ['auth']], function(){
    Route::resource('posts', PostsController::class);
//    Route::get('PostDelete/{id}',[PostsController::class, 'PostDelete')->name('PostDelete');
    Route::get('postOrder', [PostsController::class, 'postOrder'])->name('postOrder');

    Route::resource('taxonomy', TaxonomyController::class);
    Route::get('taxonomy/hide{id}', [TaxonomyController::class, 'hide'])->name('taxonomy.hide');
});

Route::group(['prefix'=>'sms','middleware'=> ['auth']], function(){
    Route::resource('smsTemplate', SmsTemplateController::class);
    Route::get('/smsBalance', [SMSController::class, 'smsBalance'])->name('smsBalance');
    Route::get('send', [SmsController::class, 'index'])->name('sms.send');
    Route::post('send', [SmsController::class, 'send'])->name('sms.send.post');
    Route::get('report', [SmsLogController::class, 'report'])->name('sms.report');
    Route::get('report-summary', [SmsLogController::class, 'reportSummary'])->name('sms.report.summary');
});


Route::group(['prefix'=>config('app.admin_prefix','admin'),'middleware'=> ['auth']], function(){
    Route::post('/menuItemStore', [MenuController::class, 'menuItemStore'])->name('menuItem.store');
    Route::post('/menuItemUpdate/{id}', [MenuController::class, 'menuItemUpdate'])->name('menuItem.update');
    Route::get('/menuItemEdit/{id}', [MenuController::class,'menuItemEdit'])->name('menuItem.edit');
    Route::get('/menuItemDelete/{id}', [MenuController::class,'menuItemDelete'])->name('menuItem.delete');
    Route::post('menu_sl', [MenuController::class, 'menuSl'])->name('menu_sl');
    
    Route::get('/siteCache', [AdminController::class, 'siteCache'])->name('siteCache');
    Route::get('/basic-settings', [AdminController::class, 'settings'])->name('settings');
    Route::put('/saveSetting/{id}', [AdminController::class,'saveSetting'])->name('saveSetting');
});

Route::group(['prefix'=>config('app.admin_prefix','admin'),'middleware'=> ['auth','role:superadmin,admin']], function(){
    Route::resource('users', UsersController::class);
    Route::resource('location', LocationController::class);
    Route::resource('menus',MenuController::class);
    Route::post('/user-ban', [UsersController::class, 'ban'])->name('user-ban');
    Route::post('/user-unban/{id}', [UsersController::class, 'unban'])->name('user-unban');
});

Route::group(['prefix'=>'admin','middleware'=> ['auth','role:superadmin']], function(){

    Route::get('ac_config_store', function()
    {
        $exitCode = Artisan::call('storage:link');
        return 'OK';
    });

    Route::get('/forceLogin/{id}', [UsersController::class, 'forceLogin'])->name('users.forceLogin');
    Route::resource('roles', RolesController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('language', LanguageController::class);    
});

require __DIR__.'/auth.php';
