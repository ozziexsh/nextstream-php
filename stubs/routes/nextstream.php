<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use \App\Http\Controllers\Nextstream;
use Laravel\Jetstream\Jetstream;
use Laravel\Fortify;

Route::group(['middleware' => ['auth:sanctum']], function () {
  Route::get('user', function (Request $request) {
    return $request->user();
  });
  Route::get('user/api-tokens', Nextstream\ListUserApiTokenController::class);
  Route::post('user/api-tokens', Nextstream\CreateApiTokenController::class);
  Route::post('user/profile-information', Nextstream\UpdateProfileInformationController::class);
  Route::delete('user', Nextstream\DeleteCurrentUserController::class);
  Route::put('api-tokens/{tokenId}', Nextstream\UpdateApiTokenController::class);
  Route::delete('api-tokens/{tokenId}', Nextstream\DeleteApiTokenController::class);
});

Route::get('features', function (Request $request) {
  return [
    'managesProfilePhotos' => Jetstream::managesProfilePhotos(),
    'hasApiFeatures' => Jetstream::hasApiFeatures(),
    'hasTeamFeatures' => Jetstream::hasTeamFeatures(),
    'canCreateNewTeamModel' => $request->user() && Jetstream::hasTeamFeatures() ? $request->user()->can('create', Jetstream::newTeamModel()) : false,
    'hasTermsAndPrivacyPolicyFeature' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
    'hasAccountDeletionFeatures' => Jetstream::hasAccountDeletionFeatures(),
    'canUpdateProfileInformation' => Fortify\Features::canUpdateProfileInformation(),
    'updatePasswords' => Fortify\Features::enabled(Fortify\Features::updatePasswords()),
    'canManageTwoFactorAuthentication' => Fortify\Features::canManageTwoFactorAuthentication(),
  ];
});
