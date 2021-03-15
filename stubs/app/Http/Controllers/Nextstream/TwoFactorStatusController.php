<?php

namespace App\Http\Controllers\Nextstream;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Ozzie\Nextstream\Nextstream;

class TwoFactorStatusController extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    return response()->json([
      'enabled' => !empty($request->user()->two_factor_recovery_codes),
    ]);
  }
}
