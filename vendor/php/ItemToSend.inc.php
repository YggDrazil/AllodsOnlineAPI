<?php

/**
 * Describes item to send from client.
 *
 * @author andrey.kuprishov
 */
class ItemToSend {
  public $shard; // String
  
  public $avatarId; // long
  
  public $itemResourceId; // int
  
  public $runeResourceId; // int
  
  public $stackCount; // int
  
  public $counter; // int
  
  public $senderName; // String
  
  public $subject; // String
  
  public $body; // String
  
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
  
  public function getSenderName() {
    return $this->senderName;
  }
  
  public function getSubject() {
    return $this->subject;
  }
  
  public function getBody() {
    return $this->body;
  }
  
}

Hessian::mapRemoteType('query.hessian.accounts.ItemToSend', 'ItemToSend');

?>