<?php

namespace App\Http\Controllers\Nextstream;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class DeleteApiTokenController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $tokenId)
    {
        $request->user()->tokens()->where('id', $tokenId)->delete();
        return response()->json();
    }
}
