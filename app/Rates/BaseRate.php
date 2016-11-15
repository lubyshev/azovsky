<?php
namespace App\Rates;

use App\Interfaces\Rate as RateInterface;

abstract class BaseRate implements RateInterface {

    protected $data = null;

    protected $dataSource = null;

    protected $rate = null;

    public function download() {
      $result = false;
      if(
        $this->dataSource &&
        $this->data = file_get_contents( $this->dataSource))
      {
          $result = true;
      }
      return $result;
    }

    public function init( $dataSource ) {
      $this->dataSource = $dataSource;
    }

    public function value() {
      return $this->rate;
    }

}
