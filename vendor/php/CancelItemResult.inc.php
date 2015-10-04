<?php

/**
 * Result of cancelling pending item.
 *
 * @author andrey.kuprishov
 */
class CancelItemResult {
  public $name;
  
  public function __construct($value = '') {
    $this->name = $value;
  }
  
  public function equals($obj) {
    return $this->name == $obj->name;
  }
  
  public static function Cancelled() {
    return new CancelItemResult('Cancelled');
  }
  
  public static function ItemActionNotFound() {
    return new CancelItemResult('ItemActionNotFound');
  }
  
  public static function ItemActionIsNotPending() {
    return new CancelItemResult('ItemActionIsNotPending');
  }
  
}

Hessian::mapRemoteType('query.hessian.accounts.CancelItemResult', 'CancelItemResult');

?>