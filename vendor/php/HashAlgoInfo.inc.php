<?php

/**
 * Hashing algorithm presentation via api.
 *
 * @author andrey.kuprishov
 */
class HashAlgoInfo {
  /**
   * Id of algorithm.
   */
  public $id; // long
  
  /**
   * Name of algorithm (e.g. SHA-1 or MD%, name is used to create message digest object).
   */
  public $name; // String
  
  /**
   * If true then we calculate hash(salt + password), if false - hash(password + salt).
   */
  public $saltThenPwd; // boolean
  
  /**
   * Charset name used to provide raw bytes to hash method. E.g. 'UTF-8'.
   */
  public $charsetName; // String
  
  public function getId() {
    return $this->id;
  }
  
  public function getName() {
    return $this->name;
  }
  
  public function isSaltThenPwd() {
    return $this->saltThenPwd;
  }
  
  public function getCharsetName() {
    return $this->charsetName;
  }
  
}

Hessian::mapRemoteType('api.account.HashAlgoInfo', 'HashAlgoInfo');

?>