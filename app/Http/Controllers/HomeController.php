<?php

namespace App\Http\Controllers;

use App\Rates\RateModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function index() {
    return view( 'pages.home', [
      'title' => 'Тестовое задание',
      'h1' => 'Текущий курс доллара к рублю',
      'currentRate' => RateModel::current(),
    ]);
  }
}
