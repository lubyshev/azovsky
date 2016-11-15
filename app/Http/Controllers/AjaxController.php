<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rates\RateModel;

class AjaxController extends Controller
{
    public function rate() {
      header('Content-type: application/json');
      $html = view( 'blocks.rate', [
        'currentRate' => RateModel::current(),
      ])->render();
      exit( json_encode( [
        'success' => $html ? true : false,
        'html' => $html,
      ]));

    }
}
