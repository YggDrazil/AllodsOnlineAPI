<?php

require_once( '../hessian/HessianClient.php' ); 
require_once('./gametool.inc.php');
require_once('./ServerVersion.inc.php');

require_once('./config.php');
require_once('./timelineCfg.inc.php');

function datetimeToTimestamp($dateTime) {
  $ts = strtotime($dateTime);
  if (($ts < 0) || ($ts === FALSE) || (strftime("%Y-%m-%d %H:%M:%S", $ts) != $dateTime)) {
    die("Failed to parse from datettime: " . $dateTime);
  }
  return $ts;
}

$url = $url = 'http://' . $config['gametool_host'] . ':' . $config['gametool_port'] . '/gametool';

// gametool is protected by username/pwd

$options = array(
  'username' => $config['gametool_user'],
  'password' => $config['gametool_pwd'],
);

$version = 2;
$serverVer = new ServerVersion($url, 'hessian/account.api', $options);
$path = $serverVer->getVersionPath($version);

if (empty($path)) {
  die("Failed to determine path to account api version $version");
}

$proxy = new HessianClient($url . $path, $options);

registerGametoolMethods($url);

$fromTs = datetimeToTimestamp($timelineCfg['from']);
$tillTs = datetimeToTimestamp($timelineCfg['till']);

$result = $proxy->getShardCCUTimeline($timelineCfg['shard_name'], $fromTs, $tillTs, $timelineCfg['step_seconds']);

$csv = fopen($timelineCfg['csv_file_name'], "w");
foreach ($result as $sample) {
  fputs($csv, strftime("%Y-%m-%d %H:%M:%S", $sample->timeSeconds) . $timelineCfg['separator'] . ' ' . $sample->ccu . "\n");
}
fclose($csv);

?>