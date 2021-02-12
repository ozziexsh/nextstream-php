<?php

namespace App\Http\Controllers\Nextstream;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Response;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteCurrentUserController extends Controller
{
    /**
     * Delete the current user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Contracts\Auth\StatefulGuard  $auth
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, StatefulGuard $auth)
    {
        $request->validate([
            'password' => 'password',
        ]);

        $user->deleteProfilePhoto();
        $user->tokens->each->delete();
        $user->delete();

        $auth->logout();

        return new Response();
    }
}
