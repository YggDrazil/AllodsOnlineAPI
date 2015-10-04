<?php

/**
 * Result of sending item. If succeeded contains ids of created actions.
 *
 * @author andrey.kuprishov
 */
class SendItemResult {
  public $status; // SendItemStatus
  
  public $error; // String
  
  public $actionIds; // long[]
  
  public function getStatus() {
    return $this->status;
  }
  
  public function getError() {
    return $this->error;
  }
  
  public function getActionIds() {
    return $this->actionIds;
  }
  
}

Hessian::mapRemoteType('query.hessian.accounts.SendItemResult', 'SendItemResult');

?>