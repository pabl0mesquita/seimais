<?php

namespace app\controllers;

use app\library\ControllerBase;
use app\library\Redirect;
use app\library\Request;

class HomeController extends ControllerBase
{
  public function __construct()
  {
    parent::__construct(__DIR__."/../../template/Web");
  }
  public function index()
  {
    echo $this->view->render('/home', []);
  }
}
