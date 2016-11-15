<?php
namespace App\Rates;

use App\Rates\BaseRate;

class CBR extends BaseRate {

  public function parse() {
    $result = false;
    if( $data = simplexml_load_string( $this->data)) {
      /* @var $data \SimpleXMLElement */
      if( $items = $data->xpath('/ValCurs/Valute[@ID="R01235"]/Value')) {
        if( isset( $items [0])) {
          $this->rate = (float) preg_replace( '~\,~', '.', $items [0]);
          $result = true;
        }
      }
    }
    return $result;
  }

}
