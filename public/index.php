<?php
require_once __DIR__.'/../app/config/bootstrap.php';

try{
    require_once __DIR__.'/../app/routes/web.php';

}catch (Exception $e) {
    var_dump($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine());
}
  