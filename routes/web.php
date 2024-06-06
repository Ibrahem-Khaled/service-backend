<?php

use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\ProviderController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::get('/', [AuthenticatedSessionController::class, 'create']);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//sevice
route::group(['prefix' => 'dashboard/service/'], function () {
    Route::get('show', [ServiceController::class, 'index'])->name('getServices');
    Route::post('store', [ServiceController::class, 'store'])->name('storeService');
    Route::post('delete/{service}', [ServiceController::class, 'delete'])->name('deleteService');
    Route::post('update/{service}', [ServiceController::class, 'update'])->name('updateService');
    Route::get('active/{service}', [ServiceController::class, 'toggle'])->name('activeService');
});

//country 
route::group(['prefix' => 'dashboard/country/'], function () {
    Route::get('show', [CountryController::class, 'index'])->name('getCountry');
    Route::post('store', [CountryController::class, 'store'])->name('storeCountry');
    Route::post('delete/{country}', [CountryController::class, 'delete'])->name('deleteCountry');
    Route::post('update/{country}', [CountryController::class, 'update'])->name('updateCountry');
});
//location 
route::group(['prefix' => 'dashboard/location/'], function () {
    Route::get('show', [LocationController::class, 'index'])->name('getLocation');
    Route::post('store', [LocationController::class, 'store'])->name('storeLocation');
    Route::post('delete/{location}', [LocationController::class, 'delete'])->name('deleteLocation');
    Route::post('update/{location}', [LocationController::class, 'update'])->name('updateLocation');
});
//gallery
route::group(['prefix' => 'dashboard/gallery/'], function () {
    Route::get('show', [GalleryController::class, 'index'])->name('getGallery');
    Route::post('delete/{gallery}', [GalleryController::class, 'delete'])->name('deleteGallery');
});


Route::prefix('admin')->group(function () {
    Route::get('/providers', [ProviderController::class, 'index'])->name('admin.providers.index');
    Route::post('/providers', [ProviderController::class, 'store'])->name('admin.providers.store');
    Route::put('/providers/{id}', [ProviderController::class, 'update'])->name('updateProviders');
    Route::post('/providers/{id}', [ProviderController::class, 'destroy'])->name('admin.providers.destroy');
    Route::get('/providers/{id}/toggle-status', [ProviderController::class, 'toggleProviderStatus'])->name('admin.providers.toggle-status');
    Route::get('/users', [ProviderController::class, 'users'])->name('admin.users.index');
});


require __DIR__ . '/auth.php';
