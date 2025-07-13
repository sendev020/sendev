<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourrierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\SuiviPersonnelController;
use App\Models\Courrier;

/*
|--------------------------------------------------------------------------
| Page d’accueil
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $nbRecu = Courrier::where('type', 'recu')->count();
    $nbEnvoye = Courrier::where('type', 'envoye')->count();
    return view('dashboard', compact('nbRecu', 'nbEnvoye'));
});

/*
|--------------------------------------------------------------------------
| Tableau de bord
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $nbRecu = Courrier::where('type', 'recu')->count();
    $nbEnvoye = Courrier::where('type', 'envoye')->count();
    return view('dashboard', compact('nbRecu', 'nbEnvoye'));
})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authentification & Profil
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Courriers
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::resource('courriers', CourrierController::class);
    Route::get('courriers/export/pdf', [CourrierController::class, 'exportPDF'])->name('courriers.export.pdf');
    Route::get('courriers/export/excel', [CourrierController::class, 'exportExcel'])->name('courriers.export.excel');
});

/*
|--------------------------------------------------------------------------
| Rapports
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::resource('rapports', RapportController::class);
    Route::patch('rapports/{rapport}/archiver', [RapportController::class, 'archiver'])->name('rapports.archiver');
    Route::patch('rapports/{rapport}/restaurer', [RapportController::class, 'restaurer'])->name('rapports.restaurer');
    Route::get('rapports/{rapport}/download', [RapportController::class, 'download'])->name('rapports.download');
});


/*
|--------------------------------------------------------------------------
| Utilisateurs (simple)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->get('/users', [UserController::class, 'index'])->name('users.index');

/*
|--------------------------------------------------------------------------
| Zone Admin (roles & permissions)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('roles', RoleController::class)->parameters(['roles' => 'role']);
    Route::resource('users', UserManagementController::class);
    Route::put('users/{user}/roles', [UserManagementController::class, 'updateRoles'])->name('users.update.roles');
    Route::put('users/{user}/permissions', [UserManagementController::class, 'updatePermissions'])->name('users.update.permissions');
});

/*
|--------------------------------------------------------------------------
| Personnels & Suivis
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::resource('personnels', PersonnelController::class);
    Route::resource('suivis', SuiviPersonnelController::class);

    Route::get('personnels/export/pdf', [PersonnelController::class, 'exportPdf'])->name('personnels.export.pdf');
    Route::get('personnels/export/excel', [PersonnelController::class, 'exportExcel'])->name('personnels.export.excel');
    Route::get('suivis/export/cumuls-pdf', [SuiviPersonnelController::class, 'exportCumulsPDF'])->name('suivis.export.cumuls');
});

/*
|--------------------------------------------------------------------------
| Authentification Laravel Breeze
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
