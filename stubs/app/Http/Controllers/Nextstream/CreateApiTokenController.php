<?php

namespace App\Http\Controllers\Nextstream;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Ozzie\Nextstream\Nextstream;

class CreateApiTokenController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $token = $request->user()->createToken(
            $request->name,
            Nextstream::validPermissions($request->input('permissions', []))
        );

        return response()->json([
            'token' => explode('|', $token->plainTextToken, 2)[1],
        ]);
    }
}
