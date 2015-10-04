<?php

/**
 * Provides result of giving item to avatar.
 * Contains status, and id of item action if succeeded.
 * Value object.
 *
 * @author andrey.kuprishov
 */
class GiveItemResult {
  public $status; // GiveItemStatus
  
  /**
   * When succeeded item action id contains id of newly created action.
   */
  public $itemActionId; // long
  
  public function getStatus() {
    return $this->status;
  }
  
  public function getItemActionId() {
    return $this->itemActionId;
  }
  
}

Hessian::mapRemoteType('query.hessian.accounts.GiveItemResult', 'GiveItemResult');

?>