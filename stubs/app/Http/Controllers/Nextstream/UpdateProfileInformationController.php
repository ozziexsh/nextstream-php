<?php

namespace App\Http\Controllers\Nextstream;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use \Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateProfileInformationController extends Controller
{
    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laravel\Fortify\Contracts\UpdatesUserProfileInformation  $updater
     * @return \Illuminate\Http\Response
     */
    public function __invoke(
        Request $request,
        UpdatesUserProfileInformation $updater
    ) {
        $updater->update($request->user(), $request->all());

        return new JsonResponse('', 200);
    }
}
