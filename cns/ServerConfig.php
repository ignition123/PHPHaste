<?php

  namespace Kernel\App\Core;
  
  require_once "cns/Config.php";
  
  $ConfigOBJ = new Config();
  $config = $ConfigOBJ->get();

  error_reporting($config->error_reporting);
  set_time_limit($config->time_limit);

  unset($ConfigOBJ);

?>