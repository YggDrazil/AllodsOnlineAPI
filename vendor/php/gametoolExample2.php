<?php

require_once('../hessian/HessianClient.php'); 

require_once('./gametool.inc.php');
require_once('./ServerVersion.inc.php');

$url = 'http://localhost:8080/gametool';

// gametool is protected by username/pwd

$options = array(
  'username' => 'vzlobin',
  'password' => '1',
);

$version = 1;
$serverVer = new ServerVersion($url, 'hessian/resource.api', $options);
$path = $serverVer->getVersionPath($version);

if (empty($path)) {
  die("Failed to determine path to resource api version $version");
}

$proxy = new HessianClient($url . $path, $options);

registerGametoolResourceMethods($url . $path);

$result = $proxy->getResource(1);

var_export($result);

?>