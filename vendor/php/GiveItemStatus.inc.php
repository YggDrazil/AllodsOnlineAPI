<?php

/**
 * Status of giving item to avatar. Used in result.
 *
 * @see query.hessian.accounts.GiveItemResult
 * @author andrey.kuprishov
 */
class GiveItemStatus {
  public $name;
  
  public function __construct($value = '') {
    $this->name = $value;
  }
  
  public function equals($obj) {
    return $this->name == $obj->name;
  }
  
  public static function Succeeded() {
    return new GiveItemStatus('Succeeded');
  }
  
  public static function ShardNotFound() {
    return new GiveItemStatus('ShardNotFound');
  }
  
  public static function AvatarNotFound() {
    return new GiveItemStatus('AvatarNotFound');
  }
  
}

Hessian::mapRemoteType('query.hessian.accounts.GiveItemStatus', 'GiveItemStatus');

?>