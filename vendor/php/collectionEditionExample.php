<?php

require_once( '../hessian/HessianClient.php' ); 

require_once('./collectionEditionApi.inc.php');
require_once('./ServerVersion.inc.php');

$url = 'http://192.168.10.229:9359';
$version = 1;

echo "URL = $url\n";

$serverVer = new ServerVersion($url, 'CollectionEditionAPI');
$path = $serverVer->getVersionPath($version);
if (is_null($path)) {
  echo "Supported versions are:\n";
  $versions = $serverVer->getSupportedVersions();
  print_r($versions);
  echo "\n";
  die("api version $version not supported");
} 

echo "Path = $path\n";

$proxy = new HessianClient($url . $path); 

registerEditionMethods($url . $path);

$result = $proxy->getCollectionEditions();

echo "\n\n=== Editions:\n\n";
var_export($result);

echo "\n\n=== Add Edition:\n\n";
$result = $proxy->addEdition(1, "Example collection edition");

echo "\n\n=== Remove Edition:\n\n";
$result = $proxy->removeEdition(1);

echo "\n\n=== Editions:\n\n";
var_export($result);

$result = $proxy->getCollectionEditions();

echo "\n\n=== Editions:\n\n";
var_export($result);

echo "\n\n=== Account editions:\n\n";
$result = $proxy->getEditionsOfAccount("oxid0");
var_export($result);

echo "\n\n=== Add edition:\n\n";
$result = $proxy->addEditionToAccount(1, "oxid0");
var_export($result);

echo "\n\n=== Account editions:\n\n";
$result = $proxy->getEditionsOfAccount("oxid0");
var_export($result);

echo "\n\n=== Remove edition:\n\n";
$result = $proxy->removeEditionFromAccount(1, "oxid0");
var_export($result);

echo "\n\n=== Account editions:\n\n";
$result = $proxy->getEditionsOfAccount("oxid0");
var_export($result);

echo "\n\n=== Remove Edition:\n\n";
$result = $proxy->removeEdition(1);

?>