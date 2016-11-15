<?php

namespace App\Interfaces;

interface Rate {

  public function download();

  public function init( $dataSource );

  public function parse();

  public function value();

}