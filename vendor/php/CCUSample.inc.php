<?php

class CCUSample {
  /**
   * Time when ccu was logged.
   */
  public $timeSeconds; // int
  
  /**
   * Number of concurrent users logged.
   */
  public $ccu; // int
  
  public function getTimeSeconds() {
    return $this->timeSeconds;
  }
  
  public function getCcu() {
    return $this->ccu;
  }
  
}

Hessian::mapRemoteType('gametool.helpers.CCUSample', 'CCUSample');

?>