<?php

/**
 * Information about item action, used in api only.
 * Fields are public because it's value object.
 *
 * @see gametool.entity.operator.ItemAction
 * @author andrey.kuprishov
 */
class ItemActionInfo {
  /**
   * Unique id of item action in gametool.
   */
  public $id; // long
  
  /**
   * Timestamp when action was created.
   */
  public $createdAt; // long
  
  /**
   * Timestamp, gametool periodically performs all pending actions with performAt less than current moment.
   */
  public $performAt; // long
  
  /**
   * Shard name where action should be performed.
   */
  public $shard; // String
  
  /**
   * Id of avatar on shard (unique inside shard only).
   */
  public $avatarId; // long
  
  /**
   * Id of item resource.
   */
  public $itemResourceId; // int
  
  /**
   * Id of rune resource, 0 if no rune in item.
   */
  public $runeResourceId; // int
  
  /**
   * Stack count for stackable items. For sinle unstackable item it should be set to 1.
   */
  public $stackCount; // int
  
  /**
   * Counter for items that contain counters. If counter not supported its value should be -1.
   */
  public $counter; // int
  
  /**
   * Status of item action.
   */
  public $status; // ItemActionStatus
  
  /**
   * Debug information for API users. Contains last error of action performing.
   */
  public $debugInfo; // String
  
  public function getId() {
    return $this->id;
  }
  
  public function getCreatedAt() {
    return $this->createdAt;
  }
  
  public function getPerformAt() {
    return $this->performAt;
  }
  
  public function getShard() {
    return $this->shard;
  }
  
  public function getAvatarId() {
    return $this->avatarId;
  }
  
  public function getItemResourceId() {
    return $this->itemResourceId;
  }
  
  public function getRuneResourceId() {
    return $this->runeResourceId;
  }
  
  public function getStackCount() {
    return $this->stackCount;
  }
  
  public function getCounter() {
    return $this->counter;
  }
  
  public function getStatus() {
    return $this->status;
  }
  
  public function getDebugInfo() {
    return $this->debugInfo;
  }
  
}

Hessian::mapRemoteType('query.hessian.accounts.ItemActionInfo', 'ItemActionInfo');

?>