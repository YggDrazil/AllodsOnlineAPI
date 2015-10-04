<?php

/**
 * Information about avatar on shard.
 *
 * @author andrey.kuprishov
 */
class AvatarOnShard {
  /**
   * Avatar id on shard, unique inside shard.
   */
  public $avatarId; // long
  
  /**
   * Avatar name.
   */
  public $avatar; // String
  
  /**
   * Shard name.
   */
  public $shard; // String
  
  /**
   * Avatar level.
   */
  public $avatarLevel; // int
  
  /**
   * Whether avatar deleted or not.
   */
  public $deleted; // boolean
  
  /**
   * Whether avatar online or not.
   */
  public $online; // boolean
  
  public function getAvatarId() {
    return $this->avatarId;
  }
  
  public function getAvatar() {
    return $this->avatar;
  }
  
  public function getShard() {
    return $this->shard;
  }
  
  public function getAvatarLevel() {
    return $this->avatarLevel;
  }
  
  public function isDeleted() {
    return $this->deleted;
  }
  
  public function isOnline() {
    return $this->online;
  }
  
}

Hessian::mapRemoteType('query.hessian.accounts.AvatarOnShard', 'AvatarOnShard');

?>