<?php

require_once( '../hessian/HessianClient.php' ); 

require_once('./accountApi.inc.php');
require_once('./ServerVersion.inc.php');
require_once('./HashAlgoInfo.inc.php');

function connect() {
  $url = 'http://192.168.10.1:9337';
  $version = 9;

  $serverVer = new ServerVersion($url, 'AccountAPI');
  $path = $serverVer->getVersionPath($version);
  if (is_null($path)) {
    echo "Supported versions are:\n";
    $versions = $serverVer->getSupportedVersions();
    print_r($versions);
    echo "\n";
    die("api version $version not supported");
  } 
  $proxy = new HessianClient($url . $path);
  registerAccountMethods($url . $path);

  echo "Working with " . $url . $path . "\n";

  return $proxy;
}

$proxy =& connect();

// !!!
// operations below should be done once (we need MD5 algorithm + operator's salt registered)
// !!!

// get all registered algorithms

$algorithms = $proxy->getAlgorithms();
echo "Supported algorithms:\n";
foreach ($algorithms as $algorithm) {
  echo "  " . $algorithm->getName() . "\n";
}

// add algorithm for md5(salt + password)
// (if it is already on server its id will be returned)

$md5AlgoId = $proxy->addAlgorithm("MD5", true, "UTF-8");

echo "Id of MD5(salt+pwd) = $md5AlgoId\n";

// register operator's salt used with algorithm
// we suggest to use some domain name of operator as operator's tag

$operatorTag = "allods-operator.com";
$salt = "ThisIsMySalt";

$result = $proxy->registerOperatorAlgorithm($operatorTag, $salt, $md5AlgoId);
if ($result->isOk()) {
  echo "Operator's algorithm registered\n";
} else {
  echo "Failed to register operator's algorithm\n";
  var_export($result);
  exit();
}

// !!!
// next operations can be used after we've registered algorithm for operator
// !!!

$userName = 'HessianTester';
$pwd = 'Gamblor';
$hash = md5($salt . $pwd);

$result = $proxy->createAccountWithHash($userName, $hash, $operatorTag,
  AccessLevel::User(), AccountStatus::Active());
if ($result->isOk()) {
  echo "Account created: $userName\n";
} else {
  echo "Failed to create account $userName, suppose it's already exist\n";
  $result = $proxy->modifyAccountHash($userName, $hash, $operatorTag);
  if ($result->isOk()) {
    echo "Hash changed for account $userName\n";
  } else {  
    echo "Failed to change hash for account $userName\n";
    var_export($result);
  }
}

// check user password against incorrect

$result = $proxy->checkPassword($userName, $pwd . 'garbage');
if (!$result->isOk()) {
  echo "Password check OK, passwords differ\n";
} else {
  echo "Password check failed\n";
  var_export($result);
  exit();
}

// check user password against correct

$result = $proxy->checkPassword($userName, $pwd);
if ($result->isOk()) {
  echo "Password check OK, passwords are same\n";
} else {
  echo "Password check failed\n";
  var_export($result);
  exit();
}


?>