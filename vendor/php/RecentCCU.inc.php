<?php

/**
 * Simple value-class for recent ccu (when and how much).
 * Leaves in .helpers package to avoid accidental rewriting by database entity class generator.
 *
 * @author andrey.kuprishov
 */
class RecentCCU {
  /**
   * Time when ccu was logged.
   */
  public $time; // long
  
  /**
   * Number of concurrent users logged.
   */
  public $ccu; // int
  
  public function getTime() {
    return $this->time;
  }
  
  public function getCcu() {
    return $this->ccu;
  }
  
}

Hessian::mapRemoteType('gametool.helpers.RecentCCU', 'RecentCCU');

?>