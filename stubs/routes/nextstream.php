<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers;
use Ozzie\Nextstream;
use Laravel\Fortify;

Route::group(['middleware' => ['web']], function () {
  Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('user', function (Request $request) {
      return ['user' => $request->user()];
    });

    if (Nextstream\Features::hasAccountDeletionFeatures()) {
      Route::delete('user', Controllers\Nextstream\DeleteCurrentUserController::class);
    }

    if (Nextstream\Features::hasApiFeatures()) {
      Route::get('user/api-tokens', Controllers\Nextstream\ListUserApiTokenController::class);
      Route::post('user/api-tokens', Controllers\Nextstream\CreateApiTokenController::class);
      Route::post('user/profile-information', Controllers\Nextstream\UpdateProfileInformationController::class);
      Route::put('api-tokens/{tokenId}', Controllers\Nextstream\UpdateApiTokenController::class);
      Route::delete('api-tokens/{tokenId}', Controllers\Nextstream\DeleteApiTokenController::class);
    }

    if (Fortify\Features::canManageTwoFactorAuthentication()) {
      Route::get('user/two-factor-status', Controllers\Nextstream\TwoFactorStatusController::class);
    }
  });

  Route::get('features', function () {
    return [
      'hasProfilePhotoFeatures' => Nextstream\Features::hasProfilePhotoFeatures(),
      'hasApiFeatures' => Nextstream\Features::hasApiFeatures(),
      'hasAccountDeletionFeatures' => Nextstream\Features::hasAccountDeletionFeatures(),
      'canUpdateProfileInformation' => Fortify\Features::canUpdateProfileInformation(),
      'updatePasswords' => Fortify\Features::enabled(Fortify\Features::updatePasswords()),
      'canManageTwoFactorAuthentication' => Fortify\Features::canManageTwoFactorAuthentication(),
    ];
  });

  Route::group(["domain" => config('nextstream.frontend_url')], function () {
    Route::get("reset-password")->name("password.reset");
  });

  Route::get('user/password-confirmation-status', function () {
    return new Response();
  })->middleware('password.confirm');
});
