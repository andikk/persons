<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Person;

class IndexController extends Controller
{
  public function start () {
    return view('index');
  }

}
