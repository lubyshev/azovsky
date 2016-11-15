<?php
namespace App\Rates;

use Illuminate\Support\Facades\Cache;

class RateModel {

  public static function current() {
    $current = false;
    if( $currentRateKey = config('rates.CurrentRateKeyName')) {
      $current = Cache::get( $currentRateKey, false);
    }
    return $current;
  }

}