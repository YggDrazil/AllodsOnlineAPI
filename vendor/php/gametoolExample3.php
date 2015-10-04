<?php

require_once('../hessian/HessianClient.php'); 

require_once('./gametool.inc.php');
require_once('./ServerVersion.inc.php');

$url = 'http://localhost:8088/gametool';

// gametool is protected by username/pwd

$options = array(
  'username' => 'admin',
  'password' => '1',
);

$version = 5;
$serverVer = new ServerVersion($url, 'hessian/account.api', $options);
$path = $serverVer->getVersionPath($version);

if (empty($path)) {
  die("Failed to determine path to account api version $version");
}

$proxy = new HessianClient($url . $path, $options);

registerGametoolMethods($url . $path);

$shard = iconv('Windows-1251', 'UTF-8', "shard_gametool_тест");

$items = array();
$items[0] = new ItemToSend();
$items[0]->shard = $shard;
$items[0]->avatarId = 1;
$items[0]->itemResourceId = 2;
$items[0]->runeResourceId = 3;
$items[0]->stackCount = 4;
$items[0]->counter = 5;
$items[0]->senderName = "kolya";
$items[0]->subject = "Hellou";
$items[0]->body = "HowAreYou";
$items[1] = new ItemToSend();
$items[1]->shard = $shard;
$items[1]->avatarId = 2;
$items[1]->itemResourceId = 3;
$items[1]->runeResourceId = 4;
$items[1]->stackCount = 5;
$items[1]->counter = 6;
$items[1]->senderName = "Masha";
$items[1]->subject = "Purkua";
$items[1]->body = "Pam-pam-pam";

$result = $proxy->multisendItemToAvatarByMail($items);

var_export($result);

die("stop");

?>