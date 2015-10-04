<?php

/**
 * Information about resource that is known to gametool.
 * Value class.
 *
 * @author andrey.kuprishov
 */
class GametoolResource {
  /**
   * Resource id from resource system.
   */
  public $id; // long
  
  /**
   * Resource type, simple name.
   */
  public $type; // String
  
  /**
   * Path to resource in resource system.
   */
  public $path; // String
  
  /**
   * Pairs of name->value data of resource.
   */
  public $namedValues; // Map<String, String>
  
  public function getId() {
    return $this->id;
  }
  
  public function getType() {
    return $this->type;
  }
  
  public function getPath() {
    return $this->path;
  }
  
  public function getNamedValues() {
    return $this->namedValues;
  }
  
}

Hessian::mapRemoteType('query.hessian.resources.GametoolResource', 'GametoolResource');

?>