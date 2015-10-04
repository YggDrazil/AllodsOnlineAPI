<?php

function registerAdminToolMethods($url) {
  $methods = array(
    'sendRequestGetResponse', // argument: request
    'getShards',  // no arguments
    'getApplications',  // argument: shard id
    'startShard', // arguments: shard id, ShardHandlingMode, AddonParams
    'stopShard',  // arguments: shard id, ShardHandlingMode
    'startApplication', // arguments: application id, AddonParams
    'stopApplication', // argument: application id
    );
  foreach ($methods as $method) {
    Hessian::remoteMethod($url, $method);
  }
}

/**
 * Request to get all base part servers.
 */
class BasePartServersRequest {  
}

/**
 * Request to determine status of base part.
 */
class BasePartStatusRequest {
  public $serverId;

  public function __construct($serverId) {
    $this->serverId = $serverId;
  }
}

/**
 * Request to start base part server.
 */
class StartBasePartRequest {
  public $serverId;
  public $addonParams;

  public function __construct($serverId, $addonParams) {
    $this->serverId    = $serverId;
    $this->addonParams = $addonParams;
  }
}

/**
 * Request to stop base part server.
 */
class StopBasePartRequest {
  public $serverId;

  public function __construct($serverId) {
    $this->serverId = $serverId;
  }
}

/**
 * Request to initiate deferred stop and optional start of shard.
 */
class DeferredStopStartRequest {
  public $noticeSenderName; // string, who sends notice (e.g. 'administration')
  public $notice; // string, notice itself (e.g. 'Maintenance will be started in 18:30')
  public $shutdownMinutes;  // int, minutes to shutdown (e.g. 15)
  public $shardIds; // array of long, shard ids to stop
  public $stopMode; // ShardHandlingMode
  public $restartNeeded;
  public $restartAddonParams;

  public function __construct($noticeSenderName, $notice, $shutdownMinutes, $shardIds, $stopMode,
    $restartNeeded, $restartAddonParams)
  {
    $this->noticeSenderName = $noticeSenderName;
    $this->notice = $notice;
    $this->shutdownMinutes = $shutdownMinutes;
    $this->shardIds = $shardIds;
    $this->stopMode = $stopMode;
    $this->restartNeeded = $restartNeeded;
    $this->restartAddonParams = $restartAddonParams;
  }
}

/**
 * Request to cancel previously initiated deferred stop on specified shards.
 */
class CancelDeferredStopRequest {
  public $noticeSenderName; // string
  public $notice; // string
  public $shardIds; // array of long

  public function __construct($noticeSenderName, $notice, $shardIds) {
    $this->noticeSenderName = $noticeSenderName;
    $this->notice = $notice;
    $this->shardIds = $shardIds;
  }
}

/**
 * Describes additional command line parameters.
 */
class AddonParams {
  public $jvmAddonParams; // string
  public $appAddonParams; // string

  public function __construct($jvmAddonParams, $appAddonParams) {
    $this->jvmAddonParams = $jvmAddonParams;
    $this->appAddonParams = $appAddonParams;
  }

  public static function getEmpty() {
    return new AddonParams("", "");
  }
}

class ShardHandlingMode {
  public $name;

  public function __construct($name) {
    $this->name = $name;
  }

  public static function WithoutStats() {
    return new ShardHandlingMode('WithoutStats');
  }

  public static function Everything() {
    return new ShardHandlingMode('Everything');
  }
}

Hessian::mapRemoteType('masterServer.commons.client.events.app.BasePartServersRequest',
                       'BasePartServersRequest');
Hessian::mapRemoteType('masterServer.commons.client.events.app.BasePartStatusRequest',
                       'BasePartStatusRequest');
Hessian::mapRemoteType('masterServer.commons.client.events.app.StartBasePartRequest',
                       'StartBasePartRequest');
Hessian::mapRemoteType('masterServer.commons.client.events.app.StopBasePartRequest',
                       'StopBasePartRequest');
Hessian::mapRemoteType('masterServer.commons.client.events.app.deferredStop.DeferredStopStartRequest',
                       'DeferredStopStartRequest');
Hessian::mapRemoteType('masterServer.commons.client.events.app.deferredStop.CancelDeferredStopRequest',
                       'CancelDeferredStopRequest');
Hessian::mapRemoteType('masterServer.commons.client.data.AddonParams',
                       'AddonParams');
Hessian::mapRemoteType('masterServer.commons.client.data.ShardHandlingMode',
                       'ShardHandlingMode');
?>