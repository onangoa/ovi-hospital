<?php

use App\Models\FrontEnd;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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

Route::get('/lang',[
    'uses' => 'App\Http\Controllers\HomeController@lang',
    'as' => 'lang.index'
]);

Route::get('/', function () {
    // try {
    //     DB::connection()->getPdo();
    //     if (!Schema::hasTable('application_settings'))
    //         return redirect('/install');
    // } catch (\Exception $e) {
    //     return redirect('/install');
    // }

    // return view('frontend.index', ['contents' => json_decode(FrontEnd::find(1)->content)]);
    return redirect()->route('login');
});

Route::get('/about', function () {
    return view('frontend.about', ['contents' => json_decode(FrontEnd::find(2)->content)]);
});

Route::get('/services', function () {
    return view('frontend.services', ['contents' => json_decode(FrontEnd::find(3)->content)]);
});

Route::get('/contact', function () {
    return view('frontend.contact', ['contents' => json_decode(FrontEnd::find(4)->content)]);
});

Route::post('/contact-form', [App\Http\Controllers\ContactUsFormController::class, 'store'])->name('contact-form.store');

Auth::routes(['register' => false]);

Route::get('/install',[
    'uses' => 'App\Http\Controllers\InstallController@index',
    'as' => 'install.index'
]);

Route::post('/install',[
    'uses' => 'App\Http\Controllers\InstallController@install',
    'as' => 'install.install'
]);


Route::group(['middleware' => ['auth']], function() {
    Route::get('/company/companyAccountSwitch', [
        'uses' => 'App\Http\Controllers\CompanyController@companyAccountSwitch',
        'as' => 'company.companyAccountSwitch'
    ]);

    Route::get('/financial-reports', [App\Http\Controllers\FinancialReportController::class, 'index'])->name('financial-reports.index');

    // Clinical Leaderboard Report
    Route::get('/clinical-leaderboard', [App\Http\Controllers\ClinicalLeaderboardController::class, 'index'])->name('clinical-leaderboard.index')->middleware('permission:clinical-leaderboard-read');
    Route::get('/clinical-leaderboard/{id}', [App\Http\Controllers\ClinicalLeaderboardController::class, 'show'])->name('clinical-leaderboard.show')->middleware('permission:clinical-leaderboard-read');

    // Weekly Wellness Check Report
    Route::get('/weekly-wellness-checks/report', [App\Http\Controllers\WeeklyWellnessCheckController::class, 'report'])->name('weekly-wellness-checks.report');

    Route::resources([
        'account-headers' => App\Http\Controllers\AccountHeaderController::class,
        'payments' => App\Http\Controllers\PaymentController::class,
        'hospital-departments' => App\Http\Controllers\HospitalDepartmentController::class,
        'doctor-details' => App\Http\Controllers\DoctorDetailController::class,
        'patient-details' => App\Http\Controllers\PatientDetailController::class,
        'doctor-assignments' => App\Http\Controllers\DoctorAssignmentController::class,
        'patient-case-studies' => App\Http\Controllers\PatientCaseStudyController::class,
        'prescriptions' => App\Http\Controllers\PrescriptionController::class,
        'lab-report-templates' => App\Http\Controllers\LabReportTemplateController::class,
        'lab-reports' => App\Http\Controllers\LabReportController::class,
        
        //To be Added
        'cvi' => App\Http\Controllers\CVIController::class,
        'care-plans' => App\Http\Controllers\CarePlanController::class,
        'initial-evaluations' => App\Http\Controllers\InitialEvaluationController::class,
        'caregiver-daily-reports' => App\Http\Controllers\CaregiverDailyReportController::class,
        'lab-requests' => App\Http\Controllers\LabRequestController::class,
        'ward-round-notes' => App\Http\Controllers\WardRoundNotesController::class,
        'weekly-wellness-checks' => App\Http\Controllers\WeeklyWellnessCheckController::class,
        'wards' => App\Http\Controllers\WardController::class,
        
        // New Modules
        'medical-referrals' => App\Http\Controllers\MedicalReferralController::class,
        'radiology-requests' => App\Http\Controllers\RadiologyRequestController::class,
        'drug-orders' => App\Http\Controllers\DrugOrderController::class,
        'nursing-cardexes' => App\Http\Controllers\NursingCardexController::class,
        'vital-signs' => App\Http\Controllers\VitalSignController::class,
    ]);

    Route::get('/components/vital-signs', [App\Http\Controllers\ComponentController::class, 'vitalSigns'])->name('components.vitalSigns');
    
    // Vital Signs Management Routes
    Route::get('/vital-sign/clinical-forms', [App\Http\Controllers\VitalSignController::class, 'clinicalFormsIndex'])->name('vital-signs.clinical-forms')->middleware('permission:vital-signs-read');
    Route::get('/vital-signs/configure-form/{clinicalForm}', [App\Http\Controllers\VitalSignController::class, 'configureClinicalForm'])->name('vital-signs.configure-form')->middleware('permission:vital-signs-read');
    Route::put('/vital-signs/update-clinical-form/{clinicalForm}', [App\Http\Controllers\VitalSignController::class, 'updateClinicalForm'])->name('vital-signs.update-clinical-form');
    Route::get('/api/vital-signs/form/{formName}', [App\Http\Controllers\VitalSignController::class, 'getVitalSignsForForm'])->name('api.vital-signs.form');

    // Patient details for lab request
    Route::get('/patients/{id}/details', [App\Http\Controllers\LabRequestController::class, 'getPatientDetails'])->name('patients.details');

    // Therapy Reports
    Route::get('/therapy-reports', [App\Http\Controllers\TherapyReportController::class, 'index'])->name('therapy-reports.index');
    Route::get('/therapy-reports/individual', [App\Http\Controllers\TherapyReportController::class, 'indexIndividual'])->name('therapy-reports.individual');
    Route::get('/therapy-reports/group', [App\Http\Controllers\TherapyReportController::class, 'indexGroup'])->name('therapy-reports.group');

    // Specific routes for individual therapy forms
    Route::get('/individual-therapy/create', [App\Http\Controllers\TherapyReportController::class, 'createIndividual'])->name('individual-therapy.create');
    Route::post('/individual-therapy', [App\Http\Controllers\TherapyReportController::class, 'storeIndividual'])->name('individual-therapy.store');
    Route::get('/individual-therapy/{therapyReport}/edit', [App\Http\Controllers\TherapyReportController::class, 'editIndividual'])->name('individual-therapy.edit');
    Route::put('/individual-therapy/{therapyReport}', [App\Http\Controllers\TherapyReportController::class, 'updateIndividual'])->name('individual-therapy.update');
    
    // Specific routes for group therapy forms
    Route::get('/group-therapy/create', [App\Http\Controllers\TherapyReportController::class, 'createGroup'])->name('group-therapy.create');
    Route::post('/group-therapy', [App\Http\Controllers\TherapyReportController::class, 'storeGroup'])->name('group-therapy.store');
    Route::get('/group-therapy/{therapyReport}/edit', [App\Http\Controllers\TherapyReportController::class, 'editGroup'])->name('group-therapy.edit');
    Route::put('/group-therapy/{therapyReport}', [App\Http\Controllers\TherapyReportController::class, 'updateGroup'])->name('group-therapy.update');

    // Routes for fetching patient/ward based on time slot
    Route::get('/individual-therapy/get-patient-by-slot', [App\Http\Controllers\TherapyReportController::class, 'getPatientByTimeSlot'])->name('individual-therapy.get-patient-by-slot');
    Route::get('/group-therapy/get-ward-by-slot', [App\Http\Controllers\TherapyReportController::class, 'getWardByTimeSlot'])->name('group-therapy.get-ward-by-slot');

    // Specific routes for individual and group therapy show views
    Route::get('/individual-therapy/{therapyReport}', [App\Http\Controllers\TherapyReportController::class, 'showIndividual'])->name('individual-therapy.show');
    Route::get('/group-therapy/{therapyReport}', [App\Http\Controllers\TherapyReportController::class, 'showGroup'])->name('group-therapy.show');

    // Generic therapy report routes (destroy only)
    Route::resource('therapy-reports', App\Http\Controllers\TherapyReportController::class)->only(['destroy']);

    // Ward assignment routes
    Route::post('/wards/{ward}/assign-patients', [App\Http\Controllers\WardController::class, 'assignPatients'])->name('wards.assign-patients');
    Route::post('/wards/{ward}/assign-doctors', [App\Http\Controllers\WardController::class, 'assignDoctors'])->name('wards.assign-doctors');
    Route::patch('/wards/{ward}/discharge-patient/{patient}', [App\Http\Controllers\WardController::class, 'dischargePatient'])->name('wards.discharge-patient');
    Route::delete('/wards/{ward}/remove-doctor/{doctor}', [App\Http\Controllers\WardController::class, 'removeDoctor'])->name('wards.remove-doctor');
    Route::delete('/wards/{ward}/remove-doctor-assignment/{assignment}', [App\Http\Controllers\WardController::class, 'removeDoctorAssignment'])->name('wards.remove-doctor-assignment');

    Route::resources([
        'front-ends' => App\Http\Controllers\FrontEndController::class,
        'contacts' => App\Http\Controllers\ContactUsController::class,
        'sms-apis' => App\Http\Controllers\SmsApiController::class,
        'sms-templates' => App\Http\Controllers\SmsTemplateController::class,
        'sms-campaigns' => App\Http\Controllers\SmsCampaignController::class,
        'email-templates' => App\Http\Controllers\EmailTemplateController::class,
        'email-campaigns' => App\Http\Controllers\EmailCampaignController::class,
        'insurances' => App\Http\Controllers\InsuranceController::class,
        'invoices' => App\Http\Controllers\InvoiceController::class,
        'roles' => App\Http\Controllers\RoleController::class,
        'users' => App\Http\Controllers\UserController::class,
        // 'currency' => App\Http\Controllers\CurrencyController::class,
        // 'tax' => App\Http\Controllers\TaxController::class,
        'smtp-configurations' => App\Http\Controllers\SmtpConfigurationController::class,
        'company' => App\Http\Controllers\CompanyController::class
    ]);

    Route::put('/front-ends/updateHome/{frontEnd}', [App\Http\Controllers\FrontEndController::class, 'updateHome'])->name('front-ends.updateHome');
    Route::put('/front-ends/updateContact/{frontEnd}', [App\Http\Controllers\FrontEndController::class, 'updateContact'])->name('front-ends.updateContact');
    Route::put('/front-ends/updateAbout/{frontEnd}', [App\Http\Controllers\FrontEndController::class, 'updateAbout'])->name('front-ends.updateAbout');
    Route::put('/front-ends/updateServices/{frontEnd}', [App\Http\Controllers\FrontEndController::class, 'updateServices'])->name('front-ends.updateServices');

    Route::get('/doctor-assignments/get-schedule/doctorwise', [App\Http\Controllers\DoctorAssignmentController::class, 'getScheduleDoctorWise'])->name('doctor-assignments.getScheduleDoctorWise');


    Route::post('/labreport/generateTemplateData',[
        'uses' => 'App\Http\Controllers\LabReportController@generateTemplateData',
        'as' => 'labreport.generateTemplateData'
    ]);

    Route::get('/lab-reports/{labReport}/export-pdf',[
        'uses' => 'App\Http\Controllers\LabReportController@exportPdf',
        'as' => 'lab-reports.exportPdf'
    ]);

    Route::post('/smsCampaign/generateTemplateData',[
        'uses' => 'App\Http\Controllers\SmsCampaignController@generateTemplateData',
        'as' => 'smsCampaign.generateTemplateData'
    ]);

    Route::post('/emailCampaign/generateTemplateData',[
        'uses' => 'App\Http\Controllers\EmailCampaignController@generateTemplateData',
        'as' => 'emailCampaign.generateTemplateData'
    ]);

    // Route::get('/c/c', [App\Http\Controllers\CurrencyController::class, 'code'])->name('currency.code');

    // Route::get('/update',[
    //     'uses' => 'App\Http\Controllers\UpdateController@index',
    //     'as' => 'update.index'
    // ]);

    Route::get('/profile/setting',[
        'uses' => 'App\Http\Controllers\ProfileController@setting',
        'as' => 'profile.setting'
    ]);

    Route::post('/profile/updateSetting',[
        'uses' => 'App\Http\Controllers\ProfileController@updateSetting',
        'as' => 'profile.updateSetting'
    ]);
    Route::get('/profile/password',[
        'uses' => 'App\Http\Controllers\ProfileController@password',
        'as' => 'profile.password'
    ]);

    Route::post('/profile/updatePassword',[
        'uses' => 'App\Http\Controllers\ProfileController@updatePassword',
        'as' => 'profile.updatePassword'
    ]);
    Route::get('/profile/view',[
        'uses' => 'App\Http\Controllers\ProfileController@view',
        'as' => 'profile.view'
    ]);

});

Route::group(['middleware' => ['auth']], function() {

    Route::get('/dashboard',[
    'uses' => 'App\Http\Controllers\DashboardController@index',
    'as' => 'dashboard'
    ]);

    Route::get('/dashboard/get-chart-data', [App\Http\Controllers\DashboardController::class, 'getChartData']);
});

Route::group(['middleware' => ['auth']], function() {

    Route::get('/apsetting',[
    'uses' => 'App\Http\Controllers\ApplicationSettingController@index',
    'as' => 'apsetting'
    ]);

    Route::post('/apsetting/update',[
    'uses' => 'App\Http\Controllers\ApplicationSettingController@update',
    'as' => 'apsetting.update'
    ]);
});

// general Setting
Route::group(['middleware' => ['auth']], function() {

    Route::get('/general',[
    'uses' => 'App\Http\Controllers\GeneralController@index',
    'as' => 'general'
    ]);

    Route::post('/general',[
    'uses' => 'App\Http\Controllers\GeneralController@edit',
    'as' => 'general'
    ]);

    Route::post('/general/localisation',[
    'uses' => 'App\Http\Controllers\GeneralController@localisation',
    'as' => 'general.localisation'
    ]);

    Route::post('/general/invoice',[
    'uses' => 'App\Http\Controllers\GeneralController@invoice',
    'as' => 'general.invoice'
    ]);

    Route::post('/general/defaults',[
    'uses' => 'App\Http\Controllers\GeneralController@defaults',
    'as' => 'general.defaults'
    ]);

});

// Hikvision Settings
Route::group(['middleware' => ['auth']], function() {

    Route::get('/hikvision',[
        'uses' => 'App\Http\Controllers\HikvisionController@index',
        'as' => 'hikvision.index'
    ]);

    Route::get('/hikvision/device-info',[
        'uses' => 'App\Http\Controllers\HikvisionController@getDeviceInfo',
        'as' => 'hikvision.getDeviceInfo'
    ]);

    Route::get('/hikvision/fingerprints',[
        'uses' => 'App\Http\Controllers\HikvisionController@getFingerprints',
        'as' => 'hikvision.getFingerprints'
    ]);

    Route::get('/hikvision/users',[
        'uses' => 'App\Http\Controllers\HikvisionController@getDeviceUsers',
        'as' => 'hikvision.getDeviceUsers'
    ]);

    Route::post('/hikvision/delete-fingerprint',[
        'uses' => 'App\Http\Controllers\HikvisionController@deleteFingerprint',
        'as' => 'hikvision.deleteFingerprint'
    ]);

    Route::post('/hikvision/add-user',[
        'uses' => 'App\Http\Controllers\HikvisionController@addUser',
        'as' => 'hikvision.addUser'
    ]);

    Route::post('/hikvision/delete-user',[
        'uses' => 'App\Http\Controllers\HikvisionController@deleteUser',
        'as' => 'hikvision.deleteUser'
    ]);

    Route::get('/hikvision/door-status',[
        'uses' => 'App\Http\Controllers\HikvisionController@getDoorStatus',
        'as' => 'hikvision.getDoorStatus'
    ]);

    Route::post('/hikvision/open-door',[
        'uses' => 'App\Http\Controllers\HikvisionController@openDoor',
        'as' => 'hikvision.openDoor'
    ]);

    Route::post('/hikvision/close-door',[
        'uses' => 'App\Http\Controllers\HikvisionController@closeDoor',
        'as' => 'hikvision.closeDoor'
    ]);

    Route::post('/hikvision/configure-notification',[
        'uses' => 'App\Http\Controllers\HikvisionController@configureNotification',
        'as' => 'hikvision.configureNotification'
    ]);

    Route::get('/hikvision/notification-hosts',[
        'uses' => 'App\Http\Controllers\HikvisionController@getNotificationHosts',
        'as' => 'hikvision.getNotificationHosts'
    ]);

    Route::post('/hikvision/delete-notification-host',[
        'uses' => 'App\Http\Controllers\HikvisionController@deleteNotificationHost',
        'as' => 'hikvision.deleteNotificationHost'
    ]);

    Route::post('/hikvision/test-notification',[
        'uses' => 'App\Http\Controllers\HikvisionController@testNotification',
        'as' => 'hikvision.testNotification'
    ]);

    Route::get('/hikvision/alert-stream',[
        'uses' => 'App\Http\Controllers\HikvisionController@getAlertStream',
        'as' => 'hikvision.getAlertStream'
    ]);

    Route::get('/hikvision/alert-listener',[
        'uses' => 'App\Http\Controllers\HikvisionController@startAlertListener',
        'as' => 'hikvision.startAlertListener'
    ]);

    Route::get('/hikvision/recent-alerts',[
        'uses' => 'App\Http\Controllers\HikvisionController@getRecentAlerts',
        'as' => 'hikvision.getRecentAlerts'
    ]);

    Route::post('/hikvision/store-alert',[
        'uses' => 'App\Http\Controllers\HikvisionController@storeAlert',
        'as' => 'hikvision.storeAlert'
    ]);

    Route::post('/hikvision/clear-alerts',[
        'uses' => 'App\Http\Controllers\HikvisionController@clearAlerts',
        'as' => 'hikvision.clearAlerts'
    ]);
});

Route::get('/home', function() {
    return redirect()->to('dashboard');
});
