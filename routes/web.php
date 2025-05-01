<?php

use App\Http\Controllers\BarangayController;
use App\Http\Controllers\CaptureImageController;
use App\Http\Controllers\CardLayoutController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\DynamicController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ScanlogController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\systemadmin\DashboardController;
use App\Http\Controllers\systemadmin\DistrictController;
use App\Http\Controllers\systemadmin\MonitoringController;
use App\Http\Controllers\systemadmin\MunicipalityController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoterController;
use App\Livewire\AccountLivewire;
use App\Livewire\ActiveVoterLivewire;
use App\Livewire\BarangayLivewire;
use App\Livewire\Camera\ImageCapture;
use App\Livewire\DashboardLivewire;
use App\Livewire\DesignationLivewire;
use App\Livewire\Faction\VoterFactionLivewire;
use App\Livewire\Guiconsulta\ProfiledAndNotPerBarangay;
use App\Livewire\InactiveVoter;
use App\Livewire\LogsLivewire;
use App\Livewire\OrganizationLivewire;
use App\Livewire\Printqr\PrintQrLivewire;
use App\Livewire\Report\ReportLivewire;
use App\Livewire\Scan\QrCodeScanner;
use App\Livewire\Upload\UploadCardLayout;
use App\Livewire\Upload\UploadVoters;
use App\Livewire\ValidatorLivewire;
use App\Livewire\VoterAnalytic;
use App\Livewire\VoterDesignationLivewire;
use App\Livewire\VoterLivewire;
use App\Livewire\VoterOrganizationLivewire;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {



    // System Admin Route
    Route::get('admin', DashboardLivewire::class)->name('admin-dashboard')->middleware(['isSuperAdmin']);



    Route::get('admin/manage/district', [DistrictController::class, 'index'])->name('admin-manage-district')->middleware(['isSuperAdmin']);
    Route::get('admin/manage/district/create', [DistrictController::class, 'create'])->name('admin-manage-district-create')->middleware(['isSuperAdmin']);
    Route::post('admin/manage/district/create', [DistrictController::class, 'store'])->name('admin-manage-district-create')->middleware(['isSuperAdmin']);
    Route::get('admin/manage/district/edit/{district}', [DistrictController::class, 'edit'])->name('admin-manage-district-edit')->middleware(['isSuperAdmin']);
    Route::post('admin/manage/district/edit/{district}', [DistrictController::class, 'update'])->name('admin-manage-district-edit')->middleware(['isSuperAdmin']);
    Route::get('admin/manage/district/destroy/{district}', [DistrictController::class, 'destroy'])->name('admin-manage-district-destroy')->middleware(['isSuperAdmin']);



    Route::get('admin/manage/municipality', [MunicipalityController::class, 'index'])->name('admin-manage-municipality')->middleware(['isSuperAdmin']);
    Route::get('admin/manage/municipality/create', [MunicipalityController::class, 'create'])->name('admin-manage-municipality-create')->middleware(['isSuperAdmin']);
    Route::post('admin/manage/municipality/create', [MunicipalityController::class, 'store'])->name('admin-manage-municipality-create')->middleware(['isSuperAdmin']);
    Route::get('admin/manage/municipality/edit/{municipality}', [MunicipalityController::class, 'edit'])->name('admin-manage-municipality-edit')->middleware(['isSuperAdmin']);
    Route::post('admin/manage/municipality/edit/{municipality}', [MunicipalityController::class, 'update'])->name('admin-manage-municipality-edit')->middleware(['isSuperAdmin']);
    Route::get('admin/manage/municipality/destroy/{municipality}', [MunicipalityController::class, 'destroy'])->name('admin-manage-municipality-destroy')->middleware(['isSuperAdmin']);

    Route::get('/get-barangays', [MunicipalityController::class, 'getBarangays'])->name('get.barangays');



    // End System Admin Routes








    Route::get('system/welcome', [PageController::class, 'index'])->name('system-welcome');

    Route::get('system/admin', DashboardLivewire::class)->name('system-dashboard')->middleware(['isAdmin']);
    // Voters
    Route::get('system/admin/voters', VoterLivewire::class)->name('system-admin-voters')->middleware(['isAdminEncoder']);
    Route::get('system/admin/inactivevoters', InactiveVoter::class)->name('system-admin-inactivevoters')->middleware(['isAdminEncoder']);
    // Active Voters
    Route::get('system/admin/active-voters', ActiveVoterLivewire::class)->name('system-admin-active-voters')->middleware(['isAdmin']);
    // Designation
    Route::get('system/admin/designations', DesignationLivewire::class)->name('system-admin-designation')->middleware(['isAdminEncoder']);
    // Organization
    Route::get('system/admin/organizations', OrganizationLivewire::class)->name('system-admin-organization')->middleware(['isAdminEncoder']);
    // Account
    Route::get('system/admin/user', AccountLivewire::class)->name('system-admin-accounts')->middleware(['isSuperAdminAdmin']);;
    // Logs
    Route::get('system/admin/logs', LogsLivewire::class)->name('system-admin-logs')->middleware(['isAdmin']);

    // Barangay
    Route::get('system/admin/barangay/list', BarangayLivewire::class)->name('system-admin-barangay-list')->middleware(['isAdminEncoder']);
    Route::get('admin/barangay/create', [BarangayController::class, 'create'])->name('admin-barangay-create')->middleware(['isAdmin']);
    Route::post('admin/barangay/add', [BarangayController::class, 'store'])->name('admin-barangay-add')->middleware(['isAdmin']);
    Route::get('admin/barangay/edit/{barangay}', [BarangayController::class, 'edit'])->name('admin-barangay-edit')->middleware(['isAdmin']);
    Route::post('admin/barangay/update/{barangay}', [BarangayController::class, 'update'])->name('admin-barangay-update')->middleware(['isAdmin']);

    Route::get('/api/barangays', [BarangayController::class, 'getBarangays']);
    Route::get('/api/municipalities', [MunicipalityController::class, 'getMunicipalities']);




    // Voter Designation
    Route::get('system/admin/voter-designations/{voter}', VoterDesignationLivewire::class)->name('system-admin-voter-designation')->middleware(['isAdminEncoder']);
    // Voter Organization
    Route::get('system/admin/voter-organizations/{voter}', VoterOrganizationLivewire::class)->name('system-admin-voter-organization')->middleware(['isAdminEncoder']);




    // Qr Printing
    // Route::get('system/admin/print-voter-qr', PrintQrLivewire::class)->name('system-admin-print-voter-qr')->middleware(['isAdminEncoder']);



    // Report Printing
    Route::get('system/admin/reports', [ReportController::class, 'index'])->name('system-admin-reports')->middleware(['isAdminEncoder']);
    Route::get('system/admin/reports/withguiconsulta', [ReportController::class, 'withoutGuiconsultaTagging'])->name('system-admin-reports-withguiconsulta')->middleware(['isAdmin']);
    Route::get('system/admin/reports/withguiconsultabayambangprofile', [ReportController::class, 'withoutGuiconsultaBayambangProfiledPerBarangay'])->name('system-admin-reports-withguiconsultabayambangprofile')->middleware(['isAdmin']);

    Route::post(
        'system/admin/generate-reports',
        [
            ReportController::class,
            'initialize'
        ]
    )->name('system-admin-generate-reports')->middleware(['isAdminEncoder']);

    Route::get(
        'system/admin/reports/municipalities/voter/report',
        [
            ReportController::class,
            'municipalTotalVoter'
        ]
    )->name('system-admin-reports-municipalities-voter-report')->middleware(['isSuperAdmin']);

    Route::get(
        'system/admin/reports/barangays/voter/report',
        [
            ReportController::class,
            'barangayTotalVoter'
        ]
    )->name('system-admin-reports-barangays-voter-report')->middleware(['isAdmin']);



    // Validator
    Route::get('system/validator/barangay-voter-list', ValidatorLivewire::class)->name('system-validator-barangay-voter-list')->middleware(['isAdminValidator']);


    // Upload Card File Format
    Route::get(
        'system/admin/upload-cardfile',
        UploadCardLayout::class
    )->name('system-admin-upload-cardfile')->middleware(['isAdminEncoder']);


    // Voter Faction
    Route::get(
        'system/admin/voter-faction',
        VoterFactionLivewire::class
    )->name('system-admin-voter-faction')->middleware(['isAdmin']);



    // Qr Code Scanner
    Route::get(
        'system/admin/qr-code-scanner',
        QrCodeScanner::class
    )->name('system-admin-qr-code-scanner')->middleware(['isAdmin']);

    // Analytics
    Route::get(
        'system/admin/barangay/voter/analytics',
        VoterAnalytic::class
    )->name('system-admin-barangay-voter-analytics')->middleware(['isSuperAdminAdmin']);






    // Controllers here...

    Route::get('admin/scanner', [ScannerController::class, 'index'])->name('admin-scanner')->middleware(['isAdminScanner']);
    Route::post('admin/scanner-result', [ScannerController::class, 'show'])->name('admin-scanner-result')->middleware(['isAdminScanner']);

    Route::get('system/validator/capture-image/{voter}', [CaptureImageController::class, 'showCamera'])->name('system-validator-capture-image')->middleware(['isAdminValidator']);

    Route::post('system/validator/save-capture-image/{voter}', [CaptureImageController::class, 'updateVoterImage'])->name('system-validator-save-capture-image')->middleware(['isAdminValidator']);

    Route::get('system/admin/print-voter-qr', [PrintController::class, 'index'])->name('system-admin-print-voter-qr')->middleware(['isAdminEncoder']);
    Route::get('system/admin/print-pinoy-worker-voter-qr', [PrintController::class, 'pinoyworker'])->name('system-admin-print-pw-voter-qr')->middleware(['isAdmin']);
    Route::post('system/admin/generate-pw-qr', [PrintController::class, 'printQrcodeForPinotWorker'])->name('system-admin-generate-pw-qr')->middleware(['isAdmin']);

    Route::get('system/admin/print-voter-qrs', [PrintController::class, 'printSelection'])->name('system-admin-selection-print-voter-qr')->middleware(['isAdminEncoder']);


    Route::get('system/admin/print-selected-voters', [PrintController::class, 'printSelected'])->name('system-admin-print-selected-voters')->middleware(['isAdminEncoder']);
    Route::post('system/admin/generate-qr', [PrintController::class, 'print'])->name('system-admin-generate-qr')->middleware(['isAdminEncoder']);
    Route::get('system/admin/generateid', [PrintController::class, 'generateIDs'])->name('system-admin-generateid')->middleware(['isAdminEncoder']);
    Route::get('system/admin/generate/pinoyworkerqr', [PrintController::class, 'printQrcodeForPinotWorker'])->name('system-admin-generate-pinoyworkerqr')->middleware(['isAdminEncoder']);




    Route::post('system/admin/dynamic-subtype', [DynamicController::class, 'getSubType'])->name('system-admin-dynamic-subtype')->middleware(['isAdminEncoder']);

    Route::get('system/admin/voters/create', [VoterController::class, 'create'])->name('system-admin-voters-create')->middleware(['isAdminEncoder']);
    Route::post('system/admin/voters/create-add', [VoterController::class, 'store'])->name('system-admin-voters-create-add')->middleware(['isAdminEncoder']);
    Route::get('system/admin/voters/edit/{voter}', [VoterController::class, 'edit'])->name('system-admin-voters-edit')->middleware(['isAdminEncoder']);
    Route::post('system/admin/voters/update/{voter}', [VoterController::class, 'update'])->name('system-admin-voters-update')->middleware(['isAdminEncoder']);
    Route::get('system/admin/validator/voters/assign_organization/{voter}', [VoterController::class, 'validatorAssignOrganization'])->name('system-admin-validator-voter-assign-organization')->middleware(['isAdminValidator']);
    Route::post('system/admin/validator/voters/assign_organization/save/{voter}', [VoterController::class, 'validatorSaveAssignOrganization'])->name('system-admin-validator-voter-assign-organization-save')->middleware(['isAdminValidator']);

    // Upload
    Route::get('system/admin/uploadfiles', [UploadController::class, 'index'])->name('system-admin-upload-voters')->middleware(['isAdminEncoder']);
    Route::post('system/admin/uploadfiles', [UploadController::class, 'upload'])->name('system-admin-uploadfiles')->middleware(['isAdminEncoder']);
    Route::get('system/admin/importCsv', [UploadController::class, 'importCsv'])->name('system-admin-importCsv')->middleware(['isAdmin']);
    Route::get('system/admin/uploadotherfiles', [UploadController::class, 'importMunicipalityCsv'])->name('system-admin-uploadotherfiles')->middleware(['isAdmin']);

    Route::get('system/admin/guiconsulta', [UploadController::class, 'uploadGuiconsulta'])->name('system-admin-guiconsulta')->middleware(['isAdmin']);


    // Download
    Route::get('system/admin/downloadformat', [DownloadController::class, 'index'])->name('system-admin-download-format')->middleware(['isAdminEncoder']);
    Route::post('system/admin/downloadformat', [DownloadController::class, 'download'])->name('system-admin-download-format')->middleware(['isAdminEncoder']);


    // Scanlogs
    Route::get('system/admin/qr/scanlogs', [ScanlogController::class, 'index'])->name('system-admin-qr-scanlogs')->middleware(['isAdmin']);
    Route::get('system/admin/qr/scanlogs/graph', [ScanlogController::class, 'scannedPerBarangay'])->name('system-admin-qr-scanlogs-graph')->middleware(['isAdmin']);


    // Map
    Route::get('system/admin/map/', [MapController::class, 'index'])->name('system-admin-map-bayambang')->middleware(['isAdmin']);
    // System Admin Map
    Route::get('system/admin/map/province', [MapController::class, 'province_map'])->name('system-admin-map-provice')->middleware(['isSuperAdmin']);


    // Change Password
    Route::get('system/admin/account/change-password', [UserController::class, 'changePasswordView'])->name('system-admin-account-change-password');
    Route::post('system/admin/account/change-password', [UserController::class, 'changePassword'])->name('system-admin-account-change-password');




    // Organizations
    Route::get('system/admin/voter/organization/create', [OrganizationController::class, 'create'])->name('system-admin-voter-organization-create');
    Route::post('system/admin/voter/organization/create', [OrganizationController::class, 'store'])->name('system-admin-voter-organization-create');

    Route::get('system/admin/voter/organization/edit/{organization}', [OrganizationController::class, 'edit'])->name('system-admin-voter-organization-edit');
    Route::post('system/admin/voter/organization/edit/{organization}', [OrganizationController::class, 'update'])->name('system-admin-voter-organization-edit');




    // Designation
    Route::get('system/admin/voter/designation/create', [DesignationController::class, 'create'])->name('system-admin-voter-designation-create');
    Route::post('system/admin/voter/designation/create', [DesignationController::class, 'store'])->name('system-admin-voter-designation-create');

    Route::get('system/admin/voter/designation/edit/{designation}', [DesignationController::class, 'edit'])->name('system-admin-voter-designation-edit');
    Route::post('system/admin/voter/designation/edit/{designation}', [DesignationController::class, 'update'])->name('system-admin-voter-designation-edit');




    // User
    Route::get('system/admin/user/create', [UserController::class, 'create'])->name('system-admin-user-create')->middleware(['isSuperAdminAdmin']);
    Route::post('system/admin/user/create', [UserController::class, 'store'])->name('system-admin-user-create')->middleware(['isSuperAdminAdmin']);







    // Super Admin Routes here ...........................................................................................................................
    // System Admin
    Route::get('system/admin/voter/uploadall', [UploadController::class, 'importMalasiquiCsv'])->name('system-admin-voter-uploadall')->middleware(['isAdmin']);




    // System Admin
    Route::get('system/admin/dashbord', [DashboardController::class, 'index'])->name('system-admin-dashboard-show')->middleware(['isSuperAdmin']);
    Route::get('system/admin/dashbord/monitoring', [DashboardController::class, 'encoderMonitoring'])->name('system-admin-dashboard-monitoring')->middleware(['isSuperAdmin']);

    Route::get('system/admin/monitoring/validator', [MonitoringController::class, 'validatorMonitoring'])->name('system-admin-monitoring-validator')->middleware(['isSuperAdmin']);
    Route::get('system/admin/monitoring/validator/view/{municipality}', [MonitoringController::class, 'viewValidatorMonitoring'])->name('system-admin-monitoring-validator-view')->middleware(['isSuperAdmin']);

    // Card Desgin Upload
    Route::get('system/admin/uploadcard', [CardLayoutController::class, 'index'])->name('system-admin-upload-card')->middleware(['isAdmin']);
    Route::post('system/admin/storecard', [CardLayoutController::class, 'store'])->name('system-admin-store-card')->middleware(['isAdmin']);




    Route::get('system/admin/validator/edit/{voter}', [VoterController::class, 'validatorEdit'])->name('system-admin-validator-edit')->middleware(['isAdminValidator']);
    Route::post('system/admin/validator/update/{voter}', [VoterController::class, 'validatorUpdate'])->name('system-admin-validator-update')->middleware(['isAdminValidator']);


    // LOG
    Route::get('system/admin/log/municipalities', [LogsController::class, 'adminLog'])->name('system-admin-log-municipalities')->middleware(['isSuperAdmin']);
    Route::get('system/admin/log/municipalities/show/{municipality}', [LogsController::class, 'showAdminLog'])->name('system-admin-log-municipalities-show')->middleware(['isSuperAdmin']);


    // Guiconsulta
    Route::get('system/guiconsulta/voter-profile', ProfiledAndNotPerBarangay::class)->name('system-guiconsulta-voter-profile')->middleware(['isAdmin']);
});
