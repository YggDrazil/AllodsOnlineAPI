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
$serverVer = new ServerVersion($url, 'hessian/account.api', $options);
$path = $serverVer->getVersionPath($version);

if (empty($path)) {
  die("Failed to determine path to account api version $version");
}

$proxy = new HessianClient($url . $path, $options);

registerGametoolMethods($url . $path);

// determine all shards known to gametool

$result = $proxy->getAllShards();

echo "Shards =\n";

foreach ($result as $shard) {
  echo "  $shard\n";
}

// request avatars of account
// also demonstrate how we can work with Russian-named elements, assuming that php script is in cp1251 encoding

$account = 'вататар';
$result = $proxy->getAvatars(iconv('Windows-1251', 'UTF-8', $account));

echo "Avatars of $account=\n";
foreach ($result as $avatar) {
  echo "  {$avatar->getAvatar()}\n";

  var_export($avatar);
}

// give item to avatar 1 on shard

$shard = "trunk_gametool";
$avatarId = 1;
$result = $proxy->giveItemToAvatar($shard, $avatarId, 123, 0, 10, 3);

echo "Result of giving item = " . $result->getStatus()->name . "\n";

if ($result->getStatus()->equals(GiveItemStatus::Succeeded())) {
  $id = $result->getItemActionId();
  echo "  item action id = $id\n";

  // check given item

  $result = $proxy->getGivenAvatarItemOnShard($shard, $id);
  if (isset($result)) {
    var_export($result);

    // cancel action

    $result = $proxy->cancelPendingAvatarItemOnShard($shard, $id);
    if ($result->equals(CancelItemResult::Cancelled())) {
      echo "cancelled\n";
    } else {
      echo $result->name . "\n";
    }

    // cancel again, should fail because already cancelled

    $result = $proxy->cancelPendingAvatarItemOnShard($shard, $id);
    if ($result->equals(CancelItemResult::Cancelled())) {
      echo "cancelled\n";
    } else {
      echo $result->name . "\n";
    }

  } else {
    echo "  action not found with id = $id\n";
  }
}

// determine all items given to avatar via API

$result = $proxy->getGivenAvatarItems("trunk_gametool", 1);
foreach ($result as $itemAction) {
  var_export($itemAction);
}

?>