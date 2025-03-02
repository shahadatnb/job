<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MenuController;

use App\Http\Controllers\StudentController;
use App\Http\Controllers\ApplicationController;

use App\Http\Controllers\SMS\SmsContactController;
use App\Http\Controllers\SMS\SmsLogController;
use App\Http\Controllers\SMS\SmsTemplateController;
use App\Http\Controllers\SMS\SMSController;

use App\Http\Controllers\TaxonomyController;
use App\Http\Controllers\PostsController;

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

Route::get('ac_config', function()
{
    Artisan::call('config:cache');
    return 'OK';
});

Route::get('/', [HomeController::class,'homepage'])->name('/');

Route::prefix(config('app.admin_prefix','admin'))->group(function() {
    //Auth::routes(['register' => false]);//['verify'=> false]
});

Route::get('/dashboard', function () {
    return redirect()->route('student.dashboard');
});

Route::get('/admin_dashboard', function () {
    return redirect()->route('home');
});

Route::group(['prefix'=>'student','middleware'=>'auth:student'], function(){  

    Route::get('/', [StudentController::class,'index'])->name('student.dashboard');
    Route::get('/profile', [StudentController::class,'profile'])->name('student.profile');
    Route::get('/editProfile', [StudentController::class,'editProfile'])->name('student.editProfile');
    Route::post('/updateProfile', [StudentController::class,'updateProfile'])->name('student.updateProfile');
    Route::post('/chengePassword', [StudentController::class,'chengePassword'])->name('student.chengePassword');

    Route::get('/application/create', [ApplicationController::class,'create'])->name('student.application.create');
    Route::post('/application/store', [ApplicationController::class,'store'])->name('student.application.store');
    Route::get('/application', [ApplicationController::class,'index'])->name('student.application.index');
    //Route::resource('unit', UnitController::class);
});

Route::group(['prefix'=>config('app.admin_prefix','admin'),'middleware'=>'auth'], function(){  

    Route::get('/home', [AdminController::class,'home'])->name('home');
    Route::post('/branchSelect', [AdminController::class,'branchSelect'])->name('branchSelect');
    Route::get('/', [AdminController::class,'index'])->name('dashboard');
    Route::get('/profile', [UsersController::class,'profile'])->name('profile');
    Route::get('/editProfile', [UsersController::class,'editProfile'])->name('editProfile');
    Route::post('/updateProfile', [UsersController::class,'updateProfile'])->name('updateProfile');
    Route::post('/chengePassword', [UsersController::class,'chengePassword'])->name('chengePassword');

    //Route::resource('unit', UnitController::class);
});
Route::get('/childLocation', [LocationController::class,'childLocation'])->name('childLocation');

Route::group(['prefix'=>config('app.admin_prefix','admin'),'middleware'=> ['auth','branch']], function(){
    
    
    
    
    Route::resource('posts', PostsController::class);
//    Route::get('PostDelete/{id}',[PostsController::class, 'PostDelete')->name('PostDelete');
    Route::get('postOrder', [PostsController::class, 'postOrder'])->name('postOrder');

    Route::resource('taxonomy', TaxonomyController::class);
    Route::get('taxonomy/hide{id}', [TaxonomyController::class, 'hide'])->name('taxonomy.hide');
});

Route::group(['prefix'=>'sms','middleware'=> ['auth']], function(){
    Route::post('contact_import', [SmsContactController::class, 'import'])->name('contact.import');
    Route::resource('contact', SmsContactController::class);
    Route::post('addCategory', [SmsContactController::class, 'addCategory'])->name('add.contact.category');
    Route::resource('smsTemplate', SmsTemplateController::class);
    Route::get('/smsBalance', [SMSController::class, 'smsBalance'])->name('smsBalance');
    Route::get('send', [SmsController::class, 'index'])->name('sms.send');
    Route::post('send', [SmsController::class, 'send'])->name('sms.send.post');
    Route::get('report', [SmsLogController::class, 'report'])->name('sms.report');
    Route::get('report-summary', [SmsLogController::class, 'reportSummary'])->name('sms.report.summary');
});


Route::group(['prefix'=>config('app.admin_prefix','admin'),'middleware'=> ['auth','branch']], function(){
    Route::post('/menuItemStore', [MenuController::class, 'menuItemStore'])->name('menuItem.store');
    Route::post('/menuItemUpdate/{id}', [MenuController::class, 'menuItemUpdate'])->name('menuItem.update');
    Route::get('/menuItemEdit/{id}', [MenuController::class,'menuItemEdit'])->name('menuItem.edit');
    Route::get('/menuItemDelete/{id}', [MenuController::class,'menuItemDelete'])->name('menuItem.delete');
    Route::post('menu_sl', [MenuController::class, 'menuSl'])->name('menu_sl');
    
    Route::get('/siteCache', [AdminController::class, 'siteCache'])->name('siteCache');
    Route::get('/basic-settings', [AdminController::class, 'settings'])->name('settings');
    Route::put('/saveSetting', [AdminController::class,'saveSetting'])->name('saveSetting');
});

Route::group(['prefix'=>config('app.admin_prefix','admin'),'middleware'=> ['auth','role:superadmin,admin']], function(){
    Route::resource('users', UsersController::class);
    Route::resource('branch', BranchController::class);
    Route::resource('location', LocationController::class);
    Route::resource('menus',MenuController::class);

    Route::post('/assignPermission/{user}', [UsersController::class, 'assignPermission'])->name('user.assignPermission');
    Route::post('/assignBranch/{user}', [UsersController::class, 'assignBranch'])->name('user.assignBranch');
    Route::post('/user-ban', [UsersController::class, 'ban'])->name('user-ban');
    Route::get('/user-unban/{id}', [UsersController::class, 'unban'])->name('user-unban');
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
