<?php

require_once('../hessian/HessianClient.php');

require_once('./AvatarOnShard.inc.php');
require_once('./GiveItemStatus.inc.php');
require_once('./GiveItemResult.inc.php');
require_once('./CancelItemResult.inc.php');
require_once('./ItemActionInfo.inc.php');
require_once('./RecentCCU.inc.php');
require_once('./CCUSample.inc.php');
require_once('./GametoolResource.inc.php');
require_once('./ItemToSend.inc.php');
require_once('./SendItemResult.inc.php');
require_once('./SendItemStatus.inc.php');

function registerGametoolMethods($fullPath) {
  $methods = array(
    'getAllShards',
    'getAvatars',
    'giveItemToAvatar',
    'getGivenAvatarItem',
    'getGivenAvatarItems',
    'cancelPendingAvatarItem',
    'getShardCCU',
    'sendItemToAvatarByMail',
    'mutisendItemToAvatarByMail',
    'getShardCCUTimeline'
    );
  foreach ($methods as $method) {
    Hessian::remoteMethod($fullPath, $method);
  }
}

function registerGametoolResourceMethods($fullPath) {
  $methods = array(
    'getResource',
    );
  foreach ($methods as $method) {
    Hessian::remoteMethod($fullPath, $method);
  }
}

?>