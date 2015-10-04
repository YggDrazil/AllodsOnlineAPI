<?php

require_once('../hessian/HessianClient.php'); 

require_once('./gametool.inc.php');
require_once('./ServerVersion.inc.php');

require_once('./AccountListLoader.inc.php');

require_once('./multiSend_config.inc.php');

$avatars = array();

foreach ($config['shards'] as $shard) {
  echo "Handling shard '" . $shard['name'] . "'\n";  

  $loader = new AccountListLoader($shard['db_host'], $shard['db_port'], $shard['db_name'], $shard['db_login'], $shard['db_password']);
  $loader->connect();

  echo "Loading accounts since " . date('Y-m-d',  $config['from_seconds']) . ", those who entered each day during " . $config['login_days'] . " day(s)\n";

  $accounts = $loader->loadAccounts($config['from_seconds'], $config['login_days']);
     
  echo "Number of accounts under criteria: " . count($accounts) . "\n";

  $avatars = $avatars + $loader->loadAvatars($accounts);
}

echo "Avatars loaded: " . count($avatars) . "\n";

$url = 'http://' . $config['master_gametool_web_host'] . ':' . $config['master_gametool_web_port'] . '/gametool';

// gametool is protected by username/pwd

$options = array(
  'username' => $config['master_gametool_username'],
  'password' => $config['master_gametool_password']
);

echo "Connecting to $url\n";

$version = 5;
$serverVer = new ServerVersion($url, 'hessian/account.api', $options);
$path = $serverVer->getVersionPath($version);

if (empty($path)) {
  die("Failed to determine path to account api version $version");
}

$proxy = new HessianClient($url . $path, $options);

registerGametoolMethods($url . $path);

$items = array();

foreach ($avatars as $avatar) {
  $gift = @($config['gifts']['classes'][$avatar['class']]);

  if (isset($gift)) {
    $item = new ItemToSend();
    $item->shard = $avatar['shard'];
    $item->avatarId = intval($avatar['id']);
    $item->runeResourceId = 0;
    $item->counter = 1;
    $item->senderName = $config['sender_name'];
    $item->subject = $config['subject'];
    $item->body = $config['body'];

    $item->itemResourceId = $gift['resource_id'];
    $item->stackCount = $gift['stack_count'];

    $items[] = $item;

    if (count($items) >= 100) {
      echo "Sending bundle of " . count($items) . " items\n";

      $result = $proxy->multisendItemToAvatarByMail($items);
      if (count($result->getActionIds()) < count($items)) {
        var_export($result);
        throw new Exception("Failed to send items: " . $result->getError());
      }

      $items = array();
    }

  } else {
    echo "Avatar " . $avatar['id'] . " error: class not found for gifts: " . $avatar['class'] . "\n";
  }
}

if (count($items) > 0) {
  echo "Sending last bundle of " . count($items) . " items\n";
  $result = $proxy->multisendItemToAvatarByMail($items);
  if (count($result->getActionIds()) < count($items)) {
    var_export($result);
    throw new Exception("Failed to send items: " . $result->getError());
  }

}

echo "Done\n";

?>