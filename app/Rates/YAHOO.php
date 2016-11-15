<?php
namespace App\Rates;

use App\Rates\BaseRate;

class YAHOO extends BaseRate {

  public function parse() {
    $result = false;
    if( $data = json_decode( $this->data, true)) {
      foreach( $data ['query'] ['results'] ['rate'] as $item ) {
        if( 'USDRUB' === $item ['id']) {
          $this->rate = (float) $item ['Rate'];
          $result = true;
          break;
        }
      }
    }
    return true;
  }

}
