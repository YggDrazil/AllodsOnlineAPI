<?php

/**
 * Status of sending item.
 *
 * @author andrey.kuprishov
 */
class SendItemStatus {
  public $name;
  
  public function __construct($value = '') {
    $this->name = $value;
  }
  
  public function equals($obj) {
    return $this->name == $obj->name;
  }
  
  public static function ShardNotFound() {
    return new SendItemStatus('ShardNotFound');
  }
  
  public static function AvatarNotFound() {
    return new SendItemStatus('AvatarNotFound');
  }
  
  public static function NotSortedByShard() {
    return new SendItemStatus('NotSortedByShard');
  }

  public static function SomeSucceeded() {
    return new SendItemStatus('SomeSucceeded');
  }
}

Hessian::mapRemoteType('query.hessian.accounts.SendItemStatus', 'SendItemStatus');

?>